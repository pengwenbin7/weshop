@extends("layouts.admin")
@section("content")
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.order.index") }}">订单列表</a></h3>
      </div>
      <div class="form-horizontal">
	<div class="box-body">
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
	    <div class="col-sm-10" v-if="canPay">
	      <div class="btn-group" v-if="payment_status == {{ $order::PAY_STATUS_WAIT }}">
		<button type="button" @click="payAll"  class="btn btn-default" name="button">全部付款</button>
		<!--
		<div class="input-group">
		<span class="input-group-btn">
		<button  @click="payPart"  class="btn btn-default" type="button">部分付款</button>
		</span>
		<input type="text" class="form-control" placeholder="部分付款金额">
		</div>
		-->
              </div>
	      <button type="button"  @click="payAll"  v-else-if="payment_status == {{ $order::PAY_STATUS_PART }}" class="btn btn-default" name="button">全部付款</button>
	      <input class="form-control"   v-else-if="payment_status == {{ $order::PAY_STATUS_DONE }}" type="text" value="完成" readonly>
	      <input class="form-control"  v-else-if="payment_status == {{ $order::PAY_STATUS_REFUND }}" type="text" value="退款" readonly>
	      <input class="form-control"  v-else-if="payment_status== {{ $order::PAY_STATUS_AFTER }}" type="text" value="货到付款" readonly>
	      <input class="form-control"  v-else-if="payment_status == {{ $order::PAY_STATUS_ERROR }}" type="text" value="错误" readonly>
	      <input class="form-control"  v-else type="text" value="未知状态" readonly>
            </div>
      	    <div class="col-sm-10" v-else>
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
      	    </div>
          </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">采购状态</label>
	    <div class="col-sm-10" v-if="canPurchase">
	      <button type="button" v-if="shipment_status == {{ $order::SHIP_STATUS_WAIT }}" @click="purchased"  class="btn btn-default" name="button">完成采购</button>
	      <input class="form-control" v-if="shipment_status > {{ $order::SHIP_STATUS_WAIT }}" type="text" value="已经采购" readonly>
            </div>

	    <div class="col-sm-10" v-else>
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

	    </div>
          </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货状态</label>
	    <div class="col-sm-10" v-if="canShip">
	      <button type="button"  @click="shipped"  v-if="shipment_status == {{ $order::SHIP_STATUS_DOING }}" class="btn btn-default" name="button">发货</button>
	      <input class="form-control"  v-else-if="shipment_status == {{ $order::SHIP_STATUS_DONE }}" type="text" value="完成发货" readonly>
	    </div>

	    <div class="col-sm-10" v-else>
	      @switch ($order->shipment_status)
	      @case ($order::SHIP_STATUS_DOING)
	      <input class="form-control" type="text" value="待发货" readonly>
	      @break
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
	    </div>
          </div>

	</div>

	<div class="box-footer">
	  @if ($order->status == $order::ORDER_STATUS_IDL)
	    <span class="btn btn-default btn-block">订单无效</span>
	  @endif
	</div>
      </div>
    </div>
  </div>
@endsection

@section("script")
  <script>
  var vue = new Vue({
    el: "#app",
    data: {
      canPay: {{ auth("admin")->user()->can("pay") }},
      canPurchase: {{ auth("admin")->user()->can("purchase") }},
      canShip: {{ auth("admin")->user()->can("ship") }},
      payment_status: {{ $order->payment_status }},
      shipment_status: {{ $order->shipment_status }}
    },
    methods: {
      payPart: function() {
        this.payment_status = 1;
      },
      payAll: function() {
	var _this = this;
	axios.post("{{ route("admin.order.paid", $order) }}")
	  .then(function (res) {
	    if (res.data.res) {
	      location.reload();
	    }
	  });
      },
      purchased: function () {
	var _this = this;
	axios.post("{{ route("admin.order.purchased", $order) }}")
	  .then(function (res) {
            location.reload();
	  });
      },
      shipped: function () {
	var _this = this;
	axios.post("{{ route("admin.order.shipped", $order) }}")
	  .then(function (res) {
	    location.reload();
	  });
      }
    }
  });
  </script>
@endsection
