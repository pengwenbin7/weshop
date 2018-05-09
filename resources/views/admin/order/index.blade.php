@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">订单</h3>
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
	  <div class="col-sm-12">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
		<tr>
		  <th>order_id</th>
		  <th>payment_id</th>
		  <th>shipment_id</th>
		  <th>user_id</th>
		  <th>admin_id</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($orders as $order)
		  <tr role="row">
		    <td>{{ $order->id }}</td>
		    <td>{{ $order->payment->id ?? "" }}</td>
		    <td>{{ $order->shipment->id ?? "" }}</td>
		    <td>{{ $order->user_id ?? "" }}</td>
		    <td>{{ $order->admin_id ?? "" }}</td>
		    <td><a href="{{ route("admin.order.show", ["id" => $order->id]) }}">详细</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	</div>
      </div>
    </div>
  </div>

@endsection
