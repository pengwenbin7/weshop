@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.order.index") }}">订单列表</a></h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.order.update", $order) }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
	  {{ method_field("PUT") }}
          <div class="form-group">
            <label for="no" class="col-sm-2 control-label">订单号</label>
            <div class="col-sm-10">
              <input class="form-control" id="no" type="text" readonly value="{{ $order->no }}">
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">用户</label>
            <div class="col-sm-10">
              <input class="form-control" type="text" readonly value="{{ $order->user->name }}">
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">收货地址</label>
            <div class="col-sm-10">
	      <input type="text" class="form-control" value="{{ $order->address->getText() }}" readonly>
            </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">应付金额</label>
            <div class="col-sm-10">
              <input class="form-control" value="{{ $order->payment->pay ?? '--' }}" readonly>
	    </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">订单状态</label>
            <div class="col-sm-10">
	      @switch ($order->status)
              @case ($order::ORDER_STATUS_WAIT)
	      <input type="text" value="待处理" readonly>
	      @break
	      @case ($order::ORDER_STATUS_DOING)
	      <input type="text" value="处理中" readonly>
	      @break
	      @case ($order::ORDER_STATUS_DONE)
	      <input type="text" value="完成" readonly>
	      @break
	      @case ($order::ORDER_STATUS_IDL)
	      <input type="text" value="无效" readonly>
	      @break
	      @deafult
	      @break
	      @endswitch
	    </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">付款状态</label>
            <div class="col-sm-10">
	      @if (auth("admin")->user()->can("pay"))
		<select class="form-control select" name="payment_status" v-model="payment_status">
		  <option value="{{ $order::PAY_STATUS_WAIT }}">待付款</option>
		  <option value="{{ $order::PAY_STATUS_PART }}">部分付款</option>
		  <option value="{{ $order::PAY_STATUS_DONE }}">完成</option>
		  <option value="{{ $order::PAY_STATUS_REFUND }}">退款</option>
		  <option value="{{ $order::PAY_STATUS_AFTER }}">到付</option>
		  <option value="{{ $order::PAY_STATUS_ERROR }}">错误</option>
		</select>
	      @else
		@switch ($order->payment_status)
		@case ($order::PAY_STATUS_WAIT)
		<input class="form-control" type="text" value="待付款" readonly>
		@break
		@case ($order::PAY_STATUS_PART)
		<input class="form-control" type="text" value="部分付款" readonly>
		@break
		@case ($order::PAY_STATUS_DONE)
		<input class="form-control" type="text" value="完成" readonly>
		@break
		@case ($order::PAY_STATUS_REFUND)
		<input class="form-control" type="text" value="退款" readonly>
		@break
		@case ($order::PAY_STATUS_AFTER)
		<input class="form-control" type="text" value="货到付款" readonly>
		@break
		@case ($order::PAY_STATUS_ERROR)
		<input class="form-control" type="text" value="错误" readonly>
		@break
		@default
		<input class="form-control" type="text" value="未知状态" readonly>
		@break
		@endswitch
	      @endif
	    </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">采购状态</label>
            <div class="col-sm-10">
	      @if (auth("admin")->user()->can("purchase") && $order->shipment_status < $order::SHIP_STATUS_PART)
		<select class="form-control select" name="shipment_status"
			v-model="shipment_status">
		  <option value="{{ $order::SHIP_STATUS_WAIT }}">待采购</option>
		  <option value="{{ $order::SHIP_STATUS_DOING }}">完成采购</option>
		</select>
	      @else
		@switch ($order->shipment_status)
		@case ($order::SHIP_STATUS_WAIT)
		<input class="form-control" type="text" value="待采购" readonly>
		@break
		@case ($order::SHIP_STATUS_DOING)
		<input class="form-control" type="text" value="完成采购" readonly>
		@break
		@default
		@break
		@endswitch
	      @endif
	    </div>
          </div>

	  <div class="form-group">
            <label class="col-sm-2 control-label">发货状态</label>
            <div class="col-sm-10">
	      @if (auth("admin")->user()->can("ship") && $order->shipment_status > $order::SHIP_STATUS_DOING && $order->shipment_status < $order::SHIP_STATUS_SURE)
		<select class="form-control select" name="shipment_status"
			v-model="shipment_status">
		  <option value="{{ $order::SHIP_STATUS_PART }}">部分发货</option>
		  <option value="{{ $order::SHIP_STATUS_DONE }}">完成发货</option>
		</select>
	      @else
		@switch ($order->shipment_status)
		@case ($order::SHIP_STATUS_PART)
		<input class="form-control" type="text" value="部分发货" readonly>
		@break
		@case ($order::SHIP_STATUS_DONE)
		<input class="form-control" type="text" value="完成发货" readonly>
		@break
		@case ($order::SHIP_STATUS_SURE)
		<input class="form-control" type="text" value="确认收货" readonly>
		@break
		@default
		@break
		<input class="form-control" type="text" value="--" readonly>
		@endswitch
	      @endif
	    </div>
          </div>

	</div>
	
	<div class="box-footer">
	  @if ($order->status != $order::ORDER_STATUS_IDL)
            <button type="submit" class="btn btn-info btn-block">确定</button>
	  @else
	    <span class="btn btn-default btn-block">订单无效</button>
	  @endif
	</div>
      </form>
    </div>
  </div>
@endsection

@section("script")
  <script>
  var vue = new Vue({
    el: "#app",
    data: {
      payment_status: {{ $order->payment_status }},
      shipment_status: {{ $order->shipment_status }}
    }
  });
  </script>
@endsection
