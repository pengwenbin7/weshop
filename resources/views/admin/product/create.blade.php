<form action="{{ url("/product") }}" method="POST">
  @csrf
  <p>name:<input name="name" type="text" value="p00"></p>
  <p>brand_id:<input name="brand_id" type="number" value="1"></p>
  <p>storage_id:<input name="storage_id" type="number" value="1"></p>
  <p>model_id:<input name="model_id" type="number" value="1"></p>
  <p>content:<input name="content" type="number" value="25"></p>
  <p>measure_unit:<input name="measure_unit" type="text" value="kg"></p>
  <p>packing_unit:<input name="packing_unit" type="text" value="包"></p>
  @submit
</form>

