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
			<form action="{{ url()->current() }}">
	      <label>
		每页
		<select name="limit" class="form-control input-sm">
			<option value="10" {{ $limit == 10 ? 'selected':'' }}>10</option>
			<option value="25" {{ $limit == 25 ? 'selected':'' }}>25</option>
			<option value="50" {{ $limit == 50 ? 'selected':'' }}>50</option>
			<option value="100" {{ $limit == 100 ? 'selected':'' }}>100</option>
		</select>
		条
	      </label>
	      <label>
		<input class="form-control input-sm" value="{{ $name }}" name="name" type="search">
		<button>搜索</button>
	      </label>
			</form>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12 table-responsive">
	    <table class="table table-bordered table-striped dataTable table-hover table-condensed" role="grid">
	      <thead>
		<tr>
		  <th>序号</th>
		  <th>订单号</th>
		  <th>地址</th>
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
		    <td>{{ $serial++ }}</td>
		    <td>{{ $order->no }}</td>
			<td><div>{{ $order->user->company->name ?? ''}}</div>
				 {{ isset($order->address->contact_name) ? $order->address->contact_name.":":'' }}
				<a href="tel:{{ isset($order->address->contact_tel) ? $order->address->contact_tel:'' }}">{{ isset($order->address->contact_tel) ? $order->address->contact_tel:'' }}</a><br>
				{{ isset($order->address) ? $order->address->getText():''}}
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
		      @if ($order->active)
			有效
		      @else
			无效
		      @endif
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
		      {{ $order->userStatus()["purchase"]["detail"] }}
		    </td>
		    <td>
		      {{ $order->userStatus()["ship"]["detail"] }}
		    </td>
		    <td><a href="{{ route("admin.order.show", ["id" => $order->id]) }}">详细</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
		<div class="col-sm-6">{{ $orders->appends(["limit" => $limit, "name" => $name])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div></div>
	</div>
      </div>
    </div>
  </div>

@endsection
