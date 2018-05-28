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
	  <div class="col-sm-12 table-responsive">
	    <table class="table table-bordered table-striped dataTable table-hover table-condensed" role="grid">
	      <thead>
		<tr>
		  <th>id</th>
		  <th>用户</th>
		  <th>金额</th>
		  <th>业务</th>
		  <th>下单时间</th>
		  <th>订单状态</th>
		  <th>付款状态</th>
		  <th>采购状态</th>
		  <th>发货状态</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($orders as $order)
		  <tr role="row">
		    <td>{{ $order->id }}</td>
		    <td>
		      {{ $order->user->name }}
		    </td>
		    <td>
		      @if ($order->payment)
			{{ $order->payment->pay }}
		      @else
			--
		      @endif
		    </td>
		    <td>{{ $order->adminUser->name }}</td>
		    <td>{{ $order->created_at }}</td>
		    <td>
		      @switch ($order->status)
		      @case ($order::ORDER_STATUS_WAIT)
		      待处理
		      @break
		      @case ($order::ORDER_STATUS_DOING)
		      处理中
		      @break
		      @case ($order::ORDER_STATUS_DONE)
		      完成
		      @break
		      @case ($order::ORDER_STATUS_IDL)
		      无效
		      @break
		      @default
		      --
		      @break
		      @endswitch
		    </td>
		    <td>
		      @switch ($order->payment_status)
		      @case ($order::PAY_STATUS_WAIT)
		      待付款
		      @break
		      @case ($order::PAY_STATUS_PART)
		      部分付款
		      @break
		      @case ($order::PAY_STATUS_DONE)
		      完成
		      @break
		      @case ($order::PAY_STATUS_REFUND)
		      退款
		      @break
		      @case ($order::PAY_STATUS_AFTER)
		      货到付款
		      @break
		      @case ($order::PAY_STATUS_ERROR)
		      错误
		      @break
		      @default
		      --
		      @break
		      @endswitch
		    </td>
		    <td>
		      @switch ($order->shipment_status)
		      @case ($order::SHIP_STATUS_WAIT)
		      待采购
		      @break
		      @default
		      采购完成
		      @break
		      @endswitch
		    </td>
		    <td>
		      @switch ($order->shipment_status)
		      @case ($order::SHIP_STATUS_DOING)
		      待发货
		      @break
		      @case ($order::SHIP_STATUS_PART)
		      部分发货
		      @break
		      @case ($order::SHIP_STATUS_DONE)
		      发货完成
		      @break
		      @case ($order::SHIP_STATUS_SURE)
		      确认收货
		      @break
		      @default
		      --
		      @break
		      @endswitch
		    </td>
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
