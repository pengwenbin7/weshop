@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.product.update", $product->id) }}" method="POST">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT"/>
    <p>name:<input name="name" type="text" value="{{ $product->name }}" required></p>
    <p>brand_id:<input name="brand_id" type="number" value="{{ $product->brand_id }}" required></p>   
    <p>model:<input name="model" type="text" value="{{ $product->model }}" required></p>
    <p>storage_id:<input name="storage_id" type="number" value="{{ $product->storage_id }}" required></p>
    <p>content:<input name="content" type="number" value="{{ $product->content }}" required></p>
    <p>measure_unit:<input name="measure_unit" type="text" value="{{ $product->measure_unit }}" required></p>
    <p>packing_unit:<input name="packing_unit" type="text" value="{{ $product->packing_unit }}" required></p>
    <p>unit_price:<input name="unit_price" type="number" value="{{ $product->variable->unit_price }}" required></p>
    <p>stock: <input name="stock" type="number" value="{{ $product->variable->stock }}"/></p>
    <p>is_ton: <input name="is_ton" type="number" value="{{ $product->is_ton }}"/></p>
    <p>sort_order:<input name="sort_order" type="number" value="{{ $product->sort_order }}" required></p>
    <input type="submit" value="ok"/>
  </form>
@endsection
