@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.product.update", $product->id) }}" method="POST">
    @csrf
    @method("PUT")
    <p>name:<input name="name" type="text" value="{{ $product->name }}" required></p>
    <p>brand_id:<input name="brand_id" type="number" value="{{ $product->brand_id }}" required></p>
    <p>model:<input name="model" type="text" value="{{ $product->model }}" required></p>
    <p>content:<input name="content" type="number" value="{{ $product->content }}" required></p>
    <p>measure_unit:<input name="measure_unit" type="text" value="{{ $product->measure_unit }}" required></p>
    <p>packing_unit:<input name="packing_unit" type="text" value="{{ $product->packing_unit }}" required></p>
    <p>ton_sell:<input name="ton_sell" type="number" value="{{ $product->ton_sell }}" required></p>
    <p>sort_order:<input name="sort_order" type="number" value="{{ $product->sort_order }}" required></p>
    @submit
  </form>
@endsection
