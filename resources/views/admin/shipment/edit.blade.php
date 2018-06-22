@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.shipment.index") }}">发货列表</a></h3>
	<h3 class="box-title">编辑</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.shipment.update", $shipment) }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
	  {{ method_field("PUT") }}

	  <div class="form-group">
	    <label class="col-sm-2 control-label">订单</label>
	    <div class="col-sm-10">
	      <a href="{{ route('admin.order.show', $shipment->order) }}">{{ $shipment->order->no }}</a>
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">采购状态</label>
	    <div class="col-sm-10">
	      <input class="form-control" readonly
		      value="{{ $shipment->purchase? "已采购": "未采购"; }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货状态</label>
	    <div class="col-sm-10">
	      <input class="form-control" readonly
		      value="{{ $shipment->status? "已发货": "未发货"; }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货地</label>
	    <div class="col-sm-10">
	      <input class="form-control" readonly
		      value="{{ $shipment->from_address }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">收货地</label>
	    <div class="col-sm-10">
	      <input class="form-control" readonly
		      value="{{ $shipment->to_address }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">物流单号</label>
	    <div class="col-sm-10">
	      <input name="ship_no" class="form-control" value="{{ $shipment->ship_no }}" type="text">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">联系人</label>
	    <div class="col-sm-10">
	      <input name="contact_name" class="form-control" value="{{ $shipment->contact_name }}" type="text">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">联系电话</label>
	    <div class="col-sm-10">
	      <input name="contact_phone" class="form-control" value="{{ $shipment->contact_phone }}" type="text">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">车牌号</label>
	    <div class="col-sm-10">
	      <input name="license_plate" class="form-control" value="{{ $shipment->license_plate }}" type="text">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">预计到达</label>
	    <div class="col-sm-10">
	      <input name="expect_arrive" class="form-control" value="{{ $shipment->expect_arrive }}" type="date">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货时间</label>
	    <div class="col-sm-10">
	      <input class="form-control" value="{{ $shipment->ship_time->toDateTimeString() }}" readonly>
            </div>
	  </div>
	  
	</div>

	@if (auth("admin")->user()->can("ship"))
	<div class="box-footer">
	    <input type="submit" class="btn btn-info btn-block" value="保存">
	</div>
	@endif
      </form>

      @if (auth("admin")->user()->can("purchase"))
	<form class="form-horizontal" action="{{ route("admin.shipment.purchased", $shipment) }}" method="POST">
	  <div class="form-group">
	    <label class="col-sm-2 control-label">采购成本</label>
	    <div class="col-sm-10">
	      <input class="form-control" name="freight" type="number"
		      required value="{{ $shipment->freight }}">
            </div>
	  </div>
	  @if (!$shipment->purchase)
	    <input type="submit" class="btn btn-info btn-block" value="完成采购">
	  @endif
	</form>
      @endif

      @if (auth("admin")->user()->can("ship"))
	<form class="form-horizontal" action="{{ route("admin.shipment.purchased", $shipment) }}" method="POST">
	  <div class="form-group">
	    <label class="col-sm-2 control-label">运费</label>
	    <div class="col-sm-10">
	      <input class="form-control" name="freight" type="number"
		      required value="{{ $shipment->freight }}">
            </div>
	  </div>
	  @if (!$shipment->ship)
	    <input type="submit" class="btn btn-info btn-block" value="完成发货">
	  @endif
	</form>
      @endif


    </div>
  </div>
@endsection
