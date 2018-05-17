@extends("layouts.admin")

@section("content")
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">分类列表</h3>
      <h3 class="box-title"><a href="{{ route("admin.category.create") }}">添加</a></h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <label>
		每页
		<select name="limit" class="form-control input-sm">
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		</select>
		条
	      </label>
	      <label>
		<input name="key" class="form-control input-sm" type="search">
		<button>搜索</button>
	      </label>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
		<tr>
		  <th>id</th>
		  <th>名称</th>
		  <th>排序</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($categories as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ $item->sort_order }}</td>
		    <td><a href="{{ route("admin.category.edit", $item) }}">编辑</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $categories->links() }}
	</div>
      </div>
    </div>
  </div>
@endsection
