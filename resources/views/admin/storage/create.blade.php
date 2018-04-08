@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.storage.store") }}" method="POST">
    @csrf
    name: <input name="name" type="text" value="测试仓库" required/><br>
    brand_id: <input name="brand_id" type="number" value="1" required><br>
    description: <input name="description" type="text" value="仓库描述"><br>
    contact_name: <input name="contact_name" type="text" value="sb"><br>
    contact_tel: <input name="contact_tel" type="text" value="12111111111"><br>
    province: <input name="province" type="text" value="北京市" required><br>
    city: <input name="city" type="text" value="北京城区" required><br>
    city_adcode: <input name="city_adcode" type="text" value="110100" required><br>
    address-detail: <input name="detail" type="text" value="地址描述"><br>
    @submit
  </form>
@endsection
