<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Region;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use DB;

class RegionUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'region:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get region info from amap.com(高德)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 初始化地区数据库
        Region::truncate();
        $client = new Client();
        $key = config("region.api_key");
        $keyword = config("region.query_root");
        $depth = config("region.query_depth");
        $url = config("region.api_url") . "?keywords=$keyword&subdistrict=$depth&key=$key";
        do {
            $request = new Request("GET", $url);
            $res = json_decode($client->send($request)->getBody());
        } while ($res->status != 1);

        $this->recRegion($res->districts);
    }

    private function recRegion($data, $pid = 0)
    {
        foreach ($data as $item) {
            if (is_string($item->citycode)) {
                $citycode = $item->citycode;
            } else {
                $citycode = json_encode($item->citycode);
            }
            $ins = [
                "parent_id" => $pid,
                "citycode" => $citycode,
                "adcode" => $item->adcode,
                "name" => $item->name,
                "center" => $item->center,
                "level" => $item->level,
            ];
            $id = Region::insertGetId($ins);
            if ($item->districts) {
                $this->recRegion($item->districts, $id);
            }
        }
    }
}
