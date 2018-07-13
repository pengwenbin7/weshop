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
		  {{--<th>发货地</th>--}}
		  <th>订单号</th>
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
{{--		    <td>{{ $item->from_address }}</td>--}}
		    <td id="gz{{ $item->order_id }}" onmousemove="tran({{ $item->order_id }})">{{ $item->order_list($item->order_id) }}</td>
			  <td><div>{{ $item->compent($item->order_id) }}</div>{{ $item->to_address }}</td>
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
  <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
  <script>
      function tran(num) {
          var onurl = "{{ route('admin.shipment.trian') }}";
          var data = {id:num};
          axios.post(onurl,data)
              .then(function (res) {
                  if(res.status == 200){
                      var p = res.data;
                      if(p.status == 'ok'){
                          layer.tips(p.info, '#gz'+num, {
                              tips: [3, '#1ab394']
                          });
                      }
                  }
              })
      }

  </script>
@endsection
