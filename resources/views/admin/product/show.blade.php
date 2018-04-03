@extends("layouts.admin")

@section("content")
  <p>id: {{ $product->id }}
  <p>name:{{ $product->name }}</p>
  <p>brand_id:{{ $product->brand_id }}</p>
  <p>model:{{ $product->model }}</p>
  <p>storage_id:{{ $product->storage_id }}</p>
  <p>content:{{ $product->content }}</p>
  <p>measure_unit:{{ $product->measure_unit }}</p>
  <p>packing_unit:{{ $product->packing_unit }}</p>
  <p>ton_sell:{{ $product->ton_sell }}</p>
  <p>last_price: {{ $product->price()->ton_price }}</p>
  <p>sort_order:{{ $product->sort_order }}</p>
  <p>detail:{{ $product->detail->content }}</p>
@endsection