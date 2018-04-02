@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.brand.store") }}" method="POST">
    @csrf
    name: <input name="name" type="text" value="测试品牌" required/>
    logo: <input name="logo" type="file" accept="image/*">
    sort_order: <input name="sort_order" type="number" value="100" required min="0" step="1"/>
    active: <input name="active" type="number" value="1" min="0" step="1" max="1"/>
    @submit
  </form>
@endsection
