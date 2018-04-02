@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.brand.update", $brand->id) }}" method="POST">
    @csrf
    @method("PUT")
    name: <input name="name" type="text" value="{{ $brand->name }}" required/>
    logo: <input name="logo" type="text" accept="{{ $brand->logo }}">
    sort_order: <input name="sort_order" type="number" value="{{ $brand->sort_order }}" required min="0" step="1"/>
    active: <input name="active" type="number" value="{{ $brand->active }}" min="0" step="1" max="1"/>
    @submit
  </form>
@endsection
