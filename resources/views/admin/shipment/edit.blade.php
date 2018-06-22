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
	    <label class="col-sm-2 control-label">运费</label>
	    <div class="col-sm-10">
	      <input class="form-control" name="freight" type="number"
		      required value="{{ $shipment->freight }}">
            </div>
	  </div>
	  
	</div>
	
	<div class="box-footer">
	  <button type="submit" class="btn btn-info btn-block">确定</button>
	</div>
      </form>
    </div>
  </div>
@endsection
