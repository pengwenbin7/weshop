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

	  <div class="form-group">
	    <label class="col-sm-2 control-label">产品明细</label>
	    <div class="col-sm-10">
	      @foreach ($shipment->shipmentItems as $item)
		<ul>
		  <li>品名：{{ $item->product_name }}</li>
		  <li>型号：{{ $item->model }}</li>
		  <li>品牌：{{ $item->brand_name }}</li>
		  <li>数量：{{ $item->number }} {{ $item->packing_unit }}</li>
		  <li>单价：{{ $item->price }}</li>
		  <li>仓库：{{ $item->storage->name }}</li>
		</ul>
	      @endforeach
	    </div>
	  </div>

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
		      value="{{ $shipment->purchase? "已采购": "未采购" }}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货状态</label>
	    <div class="col-sm-10">
	      <input class="form-control" readonly
		      value="{{ $shipment->status? "已发货": "未发货" }}">
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
	      <input name="expect_arrive" class="form-control" value="{{ $shipment->expect_arrive }}" type="date" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
            </div>
	  </div>

	  <div class="form-group">
	    <label class="col-sm-2 control-label">发货时间</label>
	    <div class="col-sm-10">
	      <input class="form-control" value="{{ $shipment->ship_time }}" readonly>
            </div>
	  </div>
	  @if (auth("admin")->user()->can("ship"))
	    <div class="box-footer">
	      <input type="submit" class="btn btn-info btn-block" value="保存">
	    </div>
	  @endif
	</div>
      </form>
    </div>

    @if (auth("admin")->user()->can("purchase"))
      <div class="box box-info">
	<div class="box-header with-border">
	  <h3 class="box-title">完成采购</h3>
	</div>
	<form class="form-horizontal" action="{{ route("admin.shipment.purchased", $shipment) }}" method="POST">
	  {{ csrf_field() }}
	  <div class="box-body">
	    <div class="form-group">
	      <label class="col-sm-2 control-label">采购成本</label>
	      <div class="col-sm-10">
		<input class="form-control" name="cost" type="number"
			required value="{{ $shipment->cost }}">
              </div>
	    </div>
	  </div>
	  <div class="box-footer">
	    @if (!$shipment->purchase)
	      <input type="submit" class="btn btn-info btn-block" value="完成采购">
	    @endif
	  </div>
	</form>
      </div>
    @endif

    @if (auth("admin")->user()->can("ship") && $shipment->purchase)
      <div class="box box-info">
	<div class="box-header with-border">
	  <h3 class="box-title">完成发货</h3>
	</div>
	<form class="form-horizontal" action="{{ route("admin.shipment.shipped", $shipment) }}" method="POST">
	  {{ csrf_field() }}
	  <div class="box-body">
	    <div class="form-group">
	      <label class="col-sm-2 control-label">运费</label>
	      <div class="col-sm-10">
		<input class="form-control" name="freight" type="number"
			required value="{{ $shipment->freight }}">
              </div>
	    </div>
	  </div>
	  @if (!$shipment->ship)
	    <div class="box-footer">
	      <input type="submit" class="btn btn-info btn-block" value="完成发货">
	    </div>
	  @endif
	</form>
      </div>
    @endif
  </div>
@endsection
