<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Region;
use App\Models\RegionVersion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use DB;
use Storage;

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
    protected $description = 'Get region info from lbs.qq.com(腾讯)';

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
        $key = config("region.key");
        $url = config("region.api") . "?key={$key}";
        $i = 0;
        do {
            $i++;
            echo "Get response from {$url}: {$i}.\n";
            $request = new Request("GET", $url);
            $res = json_decode($client->send($request)->getBody());
        } while ($res->status != 0);

        // save data version
        $version = new RegionVersion();
        $version->version = $res->data_version;
        $version->save();

        // save root region
        $region = new Region();
        $region->id = 100000;
        $region->parent_id = 0;
        $region->name = "中国";
        $region->fullname = "中华人民共和国";
        $region->lng = 116.368324;
        $region->lat = 39.915085;
        $region->level = 0;
        $region->save();

        $this->saveRegion($res->result);
    }

    private function saveRegion($data)
    {
        $provinces = $data[0];
        $bar = $this->output->createProgressBar(count($provinces));
        // 省
        foreach ($provinces as $p) {
            $ins = [];
            $ins[] = [
                "id" => $p->id,
                "parent_id" => 100000, // china code
                "name" => $p->name ?? null,
                "fullname" => $p->fullname,
                "lat" => $p->location->lat,
                "lng" => $p->location->lng,
                "level" => 1,
            ];
            // 市
            if (property_exists($p, "cidx")) {
                $cidx = $p->cidx;
                for ($i = $cidx[0]; $i <= $cidx[1]; $i++) {
                    $city = $data[1][$i];
                    $ins[] = [
                        "id" => $city->id,
                        "parent_id" => $p->id, // china code
                        "name" => $city->name ?? null,
                        "fullname" => $city->fullname,
                        "lat" => $city->location->lat,
                        "lng" => $city->location->lng,
                        "level" => 2,
                    ];
                    // 区
                    if (property_exists($city, "cidx")) {
                        for ($j = $city->cidx[0]; $j <= $city->cidx[1]; $j++) {
                            $area = $data[2][$j];
                            $ins[] = [
                                "id" => $area->id,
                                "parent_id" => $city->id,
                                "name" => $area->name ?? null,
                                "fullname" => $area->fullname,
                                "lat" => $area->location->lat,
                                "lng" => $area->location->lng,
                                "level" => 3, 
                            ];
                        }
                    }
                }
            }
            Region::insert($ins);
            $bar->advance();
        }
        $bar->finish();
        echo "\n";
    }
}
