@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.brand.index") }}">列表</a></h3>
        <h3 class="box-title">添加</h3>
	@if ($error)
	  <div class="alert alert-danger" role="alert">
	    {{ $error }}
	  </div>
	@endif
      </div>
      <form class="form-horizontal" action="{{ route("admin.brand.store") }}" method="POST">
	{{ csrf_field() }}
        <div class="box-body">
          <div class="form-group">
            <label for="name" class="col-sm-2 control-label">名字</label>
            <div class="col-sm-10">
              <input class="form-control" id="name" name="name" placeholder="不可重复" type="text" required>
            </div>
          </div>

	  <div class="form-group">
            <label for="logo" class="col-sm-2 control-label">商标</label>
            <div class="col-sm-10">
              <input id="logo" name="logo" type="file">
            </div>
          </div>

	  <div class="form-group">
            <label for="sort" class="col-sm-2 control-label">排序</label>
            <div class="col-sm-10">
              <input class="form-control" id="sort" name="sort_order" type="number" value="100" min="0" step="1" required>
            </div>
          </div>

	  <div class="form-group">
            <label for="active" class="col-sm-2 control-label">状态</label>
            <div class="col-sm-10">
              <select name="active" id="active" class="form-control">
		<option value="0">禁用</option>
		<option value="1" selected>可用</option>
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
