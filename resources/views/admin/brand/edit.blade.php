@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.brand.index") }}">列表</a></h3>
        <h3 class="box-title">编辑</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.brand.update", $brand->id) }}" method="POST">
	{{ csrf_field() }}
	<input name="_method" type="hidden" value="PUT"/>
        <div class="box-body">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">名字</label>
            <div class="col-sm-10">
              <input class="form-control" id="name" name="name" placeholder="名字不可重复" type="text" value="{{ $brand->name }}">
            </div>
          </div>

	  <div class="form-group">
            <label for="logo" class="col-sm-2 control-label">商标</label>
	    <div class="logo-view">
	      @if ($brand->logo)
		<img alt="" src="{{ $brand->logo }}"/>
	      @endif
	    </div>
            <div class="col-sm-10">
              <input id="logo" name="logo" type="file">
            </div>
          </div>

	  <div class="form-group">
            <label for="sort" class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
              <input class="form-control" id="sort" name="sort_order" type="number" value="{{ $brand->sort_order }}" min="0" step="1" required>
            </div>
          </div>

	  <div class="form-group">
            <label for="active" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
              <select name="active" id="active" class="form-control">
		@if ($brand->active == 0)
		  <option value="0" selected>禁用</option>
		  <option value="1">可用</option>
		@else
		  <option value="0">禁用</option>
		  <option value="1" selected>可用</option>
		@endif
	      </select>
            </div>
          </div>
	</div>
        <div class="box-footer">
          <button type="submit" class="btn btn-info btn-block">确定</button>
        </div>
      </form>
    </div>
  </div>
@endsection
