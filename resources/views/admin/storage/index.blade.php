@extends("layouts.admin")

@section("content")
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">仓库列表</h3>
      <h3 class="box-title"><a href="{{ route("admin.storage.create") }}">添加</a></h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}">
		品牌
		<select name="brand_id" class="select2">
		  <option value="">全部</option>
		  @foreach ($brands as $brand)
		    @if ($brand->id == $brand_id)
		      <option value="{{ $brand->id }}" selected>{{ $brand->name }}</option>
		    @else
		      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
		    @endif
		  @endforeach
		</select>
		每页<input name="limit" class="form-control input-sm"
			    value="{{ $storages->perPage() }}">
		关键词<input name="key" class="form-control input-sm"
			      value="{{ $key }}">
		<button>搜索</button>
	      </form>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
		<tr>
		  <th>序号</th>
		  <th>名称</th>
		  <th>品牌</th>
		  <th>地址</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($storages as $item)
		  <tr role="row">
		    <td>{{ $serial++ }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ $item->brand->name }}</td>
		    <td>{{ $item->address->getText() }}</td>
		    <td>
		      <a class="btn btn-small btn-info" href="{{ route("admin.storage.edit", ["id" => $item->id]) }}">编辑</a>
		      @if ($item->products->isEmpty())
			&nbsp;|&nbsp;
			<form class="inline" action="{{ route("admin.storage.destroy", $item) }}" method="POST">
			  {{ csrf_field() }}
			  {{ method_field("DELETE") }}
			  <input class="btn btn-small btn-warning" type="submit" value="删除">
			</form>
		      @endif
		    </td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $storages->appends([
	     "limit" => $limit, "brand_id" => $brand_id, "key" => $key,
	     ])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div>
	</div>
      </div>
    </div>
  </div>
@endsection
