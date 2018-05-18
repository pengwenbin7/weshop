@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">产品列表</h3>
      <h3 class="box-title">
	<a href="{{ route("admin.product.create") }}">添加</a>
      </h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <label>
		每页
		<select name="" class="form-control input-sm">
		  <option value="10">10</option>
		  <option value="25">25</option>
		  <option value="50">50</option>
		  <option value="100">100</option>
		</select>
		条
	      </label>
	      <label>
		<input class="form-control input-sm" type="search">
		<button>搜索</button>
	      </label>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12 table-responsive">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
		<tr>
		  <th>id</th>
		  <th>名字</th>
		  <th>品牌</th>
		  <th>型号</th>
		  <th>仓库</th>
		  <th>库存</th>
		  <th>价格</th>
		  <th>吨价</th>
		  <th>上架</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($products as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ $item->brand->name }}</td>
		    <td>{{ $item->model }}</td>
		    <td>{{ $item->storage->name }}</td>
		    <td>{{ $item->variable->stock }}</td>
		    <td>{{ $item->variable->unit_price }}</td>
		    <td>
		      @if ($item->is_ton)
			{{ $item->variable->unit_price * 1000 / $item->content }}
		      @else
			--
		      @endif
		    </td>
		    <td>
		      @if ($item->active)
			是
		      @else
			否
		      @endif
		    </td>
		    <td><a href="{{ route("admin.product.show", $item) }}">详细</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $products->links() }}
	</div>
      </div>
    </div>
  </div>

@endsection
