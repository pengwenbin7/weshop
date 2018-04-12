<?php

namespace Mfkj\ChianRegion\Commands;

use Illuminate\Console\Command;
use Mfkj\ChinaRegion\Models\ChinaRegion;
use Mfkj\ChinaRegion\Models\ChinaRegionVersion as Version;

class ChianRegionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chianRegion:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the Chian Region information';

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
        $url = "http://apis.map.qq.com/ws/district/v1/list?key=" .
             config("chinaRegion.key");
        $data = json_decode(file_get_contents($url), true);
        $version = new Version();
        $version->version = $data["data_version"];
        $version->save();
        $res = $data["result"];
        $provinces = $res[0];
        $bar = $this->output->createProgressBar(count($provinces));
        $ins = [];
        foreach ($provinces as $p) {
            $ins[] = [
                "id" => $p["id"],
                "name" => $p["name"],
                "fullname" => $p["fullname"],
                "lat" => $p["location"]["lat"],
                "lng" => $p["location"]["lng"],
                "parent_id" => 0,
            ];
            if (in_array("cidx", $p)) {
                for ($i = $p["cidx"][0]; $i <= $p["cidx"][1]; $i++) {
                    $city = $res[1][$i];
                    $ins[] = [
                        "id" => $city["id"],
                        "name" => $city["name"],
                        "fullname" => $city["fullname"],
                        "lat" => $city["location"]["lat"],
                        "lng" => $city["location"]["lng"],
                        "parent_id" => $p["id"],
                    ];
                    if (in_array("cidx", $city)) {
                        for ($j = $city["cidx"][0]; $j <= $city["cidx"][1]; $j++) {
                            $district = $res[2][$j];
                            $ins[] = [
                                "id" => $district["id"],
                                "name" => $district["name"],
                                "fullname" => $district["fullname"],
                                "lat" => $district["location"]["lat"],
                                "lng" => $district["location"]["lng"],
                                "parent_id" => $city["id"],
                            ];
                        }
                    }
                }
            }
            ChinaRegion::insert($ins);
            $bar->advance();
        }
        $bar->finish();
    }
}
