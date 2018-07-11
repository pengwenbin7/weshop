<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductVariable;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Storage;
use App\Events\ProductPriceChangedEvent;
use Illuminate\Support\Facades\DB;
use App\WeChat\SpreadQR;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 25);
        $name = $request->input("name", '');
        $page = $request->input("page", '');
        $active = $request->input("active", '');
        $products = Product::with(["variable", "detail", "brand", "storage"])
            ->where("keyword", "like", "%$name%")
            ->whereIn('active', [$active ? $active:0,1])
            ->orderBy("id", "desc")
            ->paginate($limit);
        $serial = 1;
        if(!empty($page) && $page != 1){
            $serial = $page * $limit - $limit + 1;
        }
        $line_num = $products -> total();
        return view("admin.product.index", [
                    "serial" => $serial,
                    "line_num" => $line_num,
                    "products" => $products,
                    'active' => $active,
                    'name' => $name,
                    'limit' => $limit
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data["limit"] = $request->input("limit", '');
        $data["name"] = $request->input("name", '');
        $data["categories"] = Category::all();
        $data["brands"] = Brand::all();
        $data["commonStorages"] = Storage::select("id", "name")
                                ->where("is_common", "=", 1)->get();
        return view("admin.product.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
         * 搜索参数 limit 显示条数 name搜索参数
         */
        $name = $request->sname;
        $limit = $request->limit;
        $product = new Product();
        $product->locale_id = $request->input("locale_id", 1);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->storage_id = $request->storage_id;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->sort_order = $request->input("sort_order", 1000);
        $product->active = $request->active;

        if (!$product->save()) {
            return ["err" => "save product error"];
        }

        // save product price
        ProductPrice::create([
            "product_id" => $product->id,
            "unit_price" => $request->unit_price,
        ]);

        // save product category
        ProductCategory::create([
            "product_id" => $product->id,
            "category_id" => $request->input("category_id"),
            "is_primary" => 1,
        ]);

        // save product variable
        ProductVariable::create([
            "product_id" => $product->id,
            "unit_price" => $request->unit_price,
            "stock" => $request->input("stock", 0),
        ]);

        $detail = $request->input("detail", false);
        if ($detail) {
            ProductDetail::create([
                "product_id" => $product->id,
                "content" => $detail,
            ]);
        }
        return redirect()->route("admin.product.index",['name' => $name,'limit' => $limit]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view("admin.product.show", ["product" => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Product $product)
    {
        return view("admin.product.edit", [
            "name" => $request->name,
            "limit" => $request->limit,
            "product" => $product,
            "categories" => Category::select("id", "name")->get(),
            "brands" => Brand::select("id", "name")->get(),
            "commonStorages" => Storage::select("id", "name")->where("is_common", "=", 1)->get(),
        ]);
    }
    
    //修改价格和库存
    public function modifying(Request $request)
    {
        if (!empty($request->number) && !empty($request->id)) {   //修改库存
            $variable = ProductVariable::where('id',$request->id)->first();
            $variable->stock = $request->number;
            $is_null = $variable->update();
            if(!empty($is_null)){
                return ['status'=>'info','msg'=>"修改成功！"];
            }else{
                return ['status'=>'error','msg'=>"修改失败！"];
            }
        }
        if (!empty($request->price) && !empty($request->id) && !empty($request->un_price)) { //修改价格
            $variable = new ProductPrice;
            $cust = Product::where('id',$request->id)->first();
            $content = Number_format($request->price*$cust->content/1000, 2, '.','');
            $user = ProductVariable::where('product_id',$cust->id)->first();
            if(!empty($user) && $user->unit_price != $request->price){
                $variable->product_id=$cust->id;
                $variable->unit_price=$content;
                $variable->save();
                $span = $user->update(['unit_price'=>$content]);
                if(!empty($span)){
                    event(new ProductPriceChangedEvent($cust));
                    return ['status' => 'ok', 'info' => "修改成功！", 'un_price' => $content];
                }else{
                    return ['status'=>'error','msg'=>"修改失败！"];
                }
            }else{
                return ['status'=>'error','msg'=>"修改失败！"];
            }
        }
        return ['status'=>'error','msg'=>"修改失败！"];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        // update product
        $name = $request->sname;
        $limit = $request->limit;
        $product->locale_id = $request->input("locale_id", 1);
        $product->name = $request->name;
        $product->brand_id = $request->brand_id;
        $product->model = $request->model;
        $product->storage_id = $request->storage_id;
        $product->content = $request->content;
        $product->measure_unit = $request->measure_unit;
        $product->packing_unit = $request->packing_unit;
        $product->active = $request->active;
        $product->sort_order = $request->input("sort_order", 1000);
        $product->save();

        // save product price
        if ($request->unit_price != $product->variable->unit_price) {
            $price = ProductPrice::create([
                "product_id" => $product->id,
                "unit_price" => $request->unit_price,
            ]);
            event(new ProductPriceChangedEvent($product));
        } 
        
        // 现在只使用单分类
        ProductCategory::where("product_id", "=", $product->id)
             ->update(["is_primary" => 0]);
        // save product primary category
        $p = ProductCategory::firstOrCreate([
            "category_id" => $request->category_id,
            "product_id" => $product->id,
        ]);
        $p->is_primary = 1;
        $p->save();
        $variable = $product->variable;
        $variable->stock = $request->stock;
        $variable->unit_price = $request->unit_price;
        $variable->save();
               
        // save product detail
        $detail = $product->detail;
        if ($request->has("detail")) {
            $detail = ProductDetail::firstOrCreate([
                "product_id" => $product->id,
            ]);
            $detail->content = $request->detail;
            $detail->save();
        }
        return redirect()->route("admin.product.index",[
            'name' => $name, 'limit' => $limit
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
}
