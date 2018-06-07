<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset = $request->input("offset", 15);
        $categories = Category::with("products")->paginate($offset);
        return view("admin.category.index", ["categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.category.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->locale_id = $request->input("locale_id", 1);
        $category->parent_id = $request->input("parent_id", 0);
        $category->sort_order = $request->input("sort_order", 100);
        $category->description = $request->input("description");
        $category->save();
        return redirect()->route("admin.category.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category->products()->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view("admin.category.edit", ["category" => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->locale_id = $request->input("locale_id", 1);
        $category->parent_id = $request->input("parent_id", 0);
        $category->sort_order = $request->input("sort_order", 100);
        $category->description = $request->input("description");
        $category->save();
        return redirect()->route("admin.category.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->products->isEmpty()) {
            $category->delete();
            return route("admin.category.index");
        } else {
            return ["err" => "The category has products, you can't delete it."];
        }
    }
}
