@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.product.store") }}" method="POST">
    @csrf
    <p>name:<input name="name" type="text" value="p00" required></p>
    <p>category_id:<input name="category_id" type="number" value="1" required></p>
    <p>brand_id:<input name="brand_id" type="number" value="1" required></p>
    <p>model:<input name="model" type="text" value="m-1" required></p>
    <p>storage_id:<input name="storage_id" type="text" value="1" required></p>
    <p>content:<input name="content" type="number" value="25" required></p>
    <p>measure_unit:<input name="measure_unit" type="text" value="kg" required></p>
    <p>packing_unit:<input name="packing_unit" type="text" value="包" required></p>
    <p>unit_price:<input name="unit_price" type="number" value="1" min="0" step="0.01" required></p>
    <p>stock:<input name="stock" type="number" value="1000" required min="0" step="1"></p>
    <p>sort_order:<input name="sort_order" type="number" value="1000" required></p>
    <p>detail:<input name="detail" type="text" value="详细" placeholder="详细信息，可以为空"></p>
    @submit
  </form>
@endsection
