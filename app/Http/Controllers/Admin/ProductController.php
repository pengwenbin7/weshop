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
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input("limit", 15);
        $name = $request->input("name", '');
        $products = Product::with(["variable", "detail", "brand", "storage"])
            ->where("keyword", "like", "%$name%")
            ->orderBy("id", "desc")
            ->paginate($limit);
        return view("admin.product.index", ["products" => $products,'name'=>$name,'limit'=>$limit]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data["categories"] = Category::all();
        $data["brands"] = Brand::all();
        $data["storages"] = Storage::all();
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
        
        return redirect()->route("admin.product.index");
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
    public function edit(Product $product)
    {
        return view("admin.product.edit", [
            "product" => $product,
            "categories" => Category::select("id", "name")->get(),
            "brands" => Brand::select("id", "name")->get(),
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
                return response()->json(['status'=>'info','msg'=>"修改成功！"]);
            }else{
                return response()->json(['status'=>'error','msg'=>"修改失败！"]);
            }
        }
        if (!empty($request->price) && !empty($request->id) && !empty($request->un_price)) { //修改价格
            $variable = new ProductPrice;
            $cust = Product::where('id',$request->id)->first();
            $content = Number_format($request->price*$cust->content/1000, 2, '.','');
            $user = ProductVariable::where('product_id',$cust->id)->first();
            if(!empty($user) && $user->unit_price != $request->price){
                $variable->product_id=$cust->id;
                $variable->unit_price=$user->unit_price;
                $variable->created_at=date('Y-m-d H:i:s',time());
                $variable->updated_at=date('Y-m-d H:i:s',time());
                DB::beginTransaction();
                try{
                    $variable->save();
                    $user->update(['unit_price'=>$content]);
                    DB::commit();
                    return response()->json(['status'=>'ok','info'=>"修改成功！",'un_price'=>$content]);
                    //中间逻辑代码
                    DB::commit();
                }catch (\Exception $e) {
                    //接收异常处理并回滚
                    DB::rollBack();
                    return response()->json(['status'=>'error','msg'=>"修改失败！"]);
                }
            }else{
                return response()->json(['status'=>'error','msg'=>"修改失败！"]);
            }
        }
        return response()->json(['status'=>'error','msg'=>"修改失败！"]);
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

        return redirect()->route("admin.product.index");
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
