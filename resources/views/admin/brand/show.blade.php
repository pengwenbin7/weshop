@extends("layouts.admin")

@section("content")
  <div class="box-header with-border">
    <h3 class="box-title"><a href="{{ route("admin.brand.index") }}">列表</a></h3>
    <h3 class="box-title">编辑</h3>
  </div>
  <div>
    <label>id</label>
    {{ $brand->id }}
  </div>
  <div>
    <label>名字</label>
    {{ $brand->name }}
  </div>
  <div>
    <label>logo</label>
    {{ $brand->logo }}
  </div>
  <div>
    <label>排序</label>
    {{ $brand->sort_order }}
  </div>
  <div>
    <label>可用</label>
    @if ($brand->active)
      是
    @else
      否
    @endif
  </div>
@endsection
