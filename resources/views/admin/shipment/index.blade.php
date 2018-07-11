@extends("layouts.admin")

@section("content")
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">发货单</h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}">
		每页
		<input name="limit" value="{{ $shipments->perPage() }}"
			required class="form-control input-sm">
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
		  <th>发货地</th>
		  <th>收货地</th>
		  <th>采购状态</th>
		  <th>发货状态</th>
		  <th>采购成本</th>
		  <th>物流成本</th>
		  <th>发货时间</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($shipments as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>{{ $item->from_address }}</td>
		    <td>{{ $item->to_address }}</td>

		    <td>{{ $item->purchase ? "已采购": "未采购" }}</td>
		    <td>{{ $item->status ? "已发货": "未发货" }}</td>
		    <td>{{ $item->cost }}</td>
		    <td>{{ $item->freight }}</td>
		    <td>{{ $item->created_at }}</td>
		    <td><a href="{{ route("admin.shipment.edit", $item) }}">编辑</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $shipments->appends(["limit" => $limit])->links() }}
	</div>
      </div>
    </div>
  </div>
@endsection
