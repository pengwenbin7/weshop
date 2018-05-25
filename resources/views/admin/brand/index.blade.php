@extends("layouts.admin")

@section("content")
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">品牌列表</h3>
      <h3 class="box-title"><a href="{{ route("admin.brand.create") }}">添加</a></h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}">
		每页
		<input name="limit" value="{{ $brands->perPage() }}"
			required class="form-control input-sm">
		关键词
		<input name="key" class="form-control input-sm" type="text"
			value="{{ $key }}">
		
		<input name="page" type="hidden" value="{{ $brands->currentPage() }}">
		<button class="btn btn-default">搜索</button>
	      </form>
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
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($brands as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>{{ $item->name }}</td>
		    <td><a href="{{ route("admin.brand.edit", $item) }}">编辑</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $brands->appends(["key" => $key, "limit" => $limit])->links() }}
	</div>
      </div>
    </div>
  </div>
@endsection
