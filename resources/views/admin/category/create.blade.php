@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">添加</h3>
	<h3 class="box-title"><a href="{{ route("admin.category.index") }}">分类列表</a></h3>
      </div>
      <form action="{{ route("admin.category.store") }}" method="POST" class="form-horizontal">
	<div class="box-body">
	  {{ csrf_field() }}
	  <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">名字</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="name" name="name" type="text" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="sort" class="col-sm-2 control-label">顺序</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="sort" name="sort_order" type="number"
		      min="0" max="100000" step="1" value="100" required>
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="description" class="col-sm-2 control-label">描述</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="description" name="description" type="text"
		      placeholder="可以为空">
	    </div>
	  </div>
	</div>
	<div class="box-footer">
	  <div class="form-group">
	    <button id="content" type="submit" class="btn btn-info btn-block">确定</button>
	  </div>
	</div>
      </form>
    </div>
  </div>
@endsection
