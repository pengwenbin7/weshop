@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.category.store") }}" method="POST">
    {{ csrf_field() }}
    名字:
    <input name="name" type="text" value="" required>
    
    顺序(越小越靠前)：
    <input name="sort_order" type="number" value="100" min="0" step="1"/>

    描述:
    <input name="description" type="text" value="" placeholder="可以为空">
    <input type="submit" value="submit"/>
  </form>
@endsection
