@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.category.update", $category->id) }}" method="POST">
    {{ csrf_field() }}
    <input name="_method" type="hidden" value="PUT"/>
    名字:
    <input name="name" type="text" value="{{ $category->name }}" required>
    
    顺序(越小越靠前)：
    <input name="sort_order" type="number" value="{{ $category->sort_order }}" min="0" step="1"/>

    描述:
    <input name="description" type="text" value="{{ $category->description }}" placeholder="可以为空">
    <input name="" type="submit" value="确定"/>
  </form>
  
@endsection

