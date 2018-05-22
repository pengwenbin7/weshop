<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;
use App\Models\Address;
use App\Models\Category;
use App\Models\Storage;
use App\Models\Product;
use App\Models\ProductVariable;
use App\Models\ProductCategory;


class DemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'initial demo data';

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
        $b1 = Brand::firstOrCreate([
            "name" => "品牌1",
            "locale_id" => 1,
        ]);
        $b2 = Brand::firstOrCreate([
            "name" => "品牌2",
            "locale_id" => 1,
        ]);
        $a = Address::create([
            "contact_name" => "地址人",
            "contact_tel" => "13100000000",
            "country" => "中华人民共和国",
            "province" => "四川省",
            "city" => "广元市",
            "district" => "苍溪县",
            "detail" => "某某街道",
            "code" => 510824,            
        ]);
        $s1 = Storage::firstOrCreate([
            "name" => "1号仓库",
            "brand_id" => $b1->id,
            "address_id" => $a->id,
            "func" => sys_config("storage.func"),
        ]);
        $s2 = Storage::firstOrCreate([
            "name" => "2号仓库",
            "brand_id" => $b2->id,
            "address_id" => $a->id,
            "func" => sys_config("storage.func"),
        ]);
        $c1 = Category::firstOrCreate([
            "name" => "分类1",
            "locale_id" => 1,
            "sort_order" => 2,
        ]);
        $c2 = Category::firstOrCreate([
            "name" => "分类2",
            "locale_id" => 1,
            "sort_order" => 1,
        ]);

        $p1 = Product::create([
            "name" => "产品1",
            "brand_id" => $b1->id,
            "storage_id" => $s1->id,
            "model" => "型号1",
            "content" => 25,
            "measure_unit" => "kg",
            "packing_unit" => "包",
        ]);

        $p2 = Product::create([
            "name" => "产品2",
            "brand_id" => $b1->id,
            "storage_id" => $s1->id,
            "model" => "型号2",
            "content" => 51,
            "measure_unit" => "kg",
            "packing_unit" => "箱",
        ]);
        
        $p3 = Product::create([
            "name" => "产品3",
            "brand_id" => $b2->id,
            "storage_id" => $s2->id,
            "model" => "型号3",
            "content" => 50,
            "measure_unit" => "kg",
            "packing_unit" => "包",
        ]);

        ProductVariable::firstOrCreate([
            "product_id" => $p1->id,
            "unit_price" => 100,
            "stock" => 2000,
        ]);

        ProductVariable::firstOrCreate([
            "product_id" => $p2->id,
            "unit_price" => 25,
            "stock" => 9999,
        ]);

        ProductVariable::firstOrCreate([
            "product_id" => $p3->id,
            "unit_price" => 500,
            "stock" => 9239, 
        ]);

        ProductCategory::firstOrCreate([
            "product_id" => $p1->id,
            "category_id" => $c1->id,
            "is_primary" => 1,
        ]);
        
        ProductCategory::firstOrCreate([
            "product_id" => $p2->id,
            "category_id" => $c1->id,
            "is_primary" => 1,
        ]);
        
        ProductCategory::firstOrCreate([
            "product_id" => $p3->id,
            "category_id" => $c2->id,
            "is_primary" => 1,
        ]);        
    }
}
