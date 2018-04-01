<form action="{{ route("admin.brand.store") }}" method="POST">
  @csrf
  <input name="name" type="text" value="测试品牌"/>
  <input name="supplier_id" type="number" value="1"/>
  @submit
</form>
