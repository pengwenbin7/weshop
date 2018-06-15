@extends("layouts.admin")

@section("content")
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">发票列表</h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}">
		每页
		<input name="limit" value="{{ $invoices->perPage() }}"
			required class="form-control input-sm">
		订单号
		<input name="key" class="form-control input-sm" type="text"
			value="{{ $key }}">

		<input name="page" type="hidden" value="{{ $invoices->currentPage() }}">
		<button class="btn btn-default">搜索</button>
	      </form>
	    </div>
	  </div>
	</div>
	<div class="row">
	  <div class="col-sm-12 table-responsive">
	    <table class="table table-bordered table-striped dataTable" role="grid">
	      <thead>
		<tr>
		  <th>id</th>
		  <th>订单号</th>
		  <th>状态</th>
		  <th>快递单号</th>
		  <th>收票人</th>
		  <th>开票人</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($invoices as $item)
		  <tr role="row">
		    <td>{{ $item->id }}</td>
		    <td>
		      <a href="{{ route("admin.order.show", $item->order_id) }}">
			{{ $item->order->no }}
		      </a>
		    </td>
		    <td>
		      @switch ($item->status)
		      @case ($item::WAIT)
		      未申请
		      @break
		      @case ($item::REQUEST)
		      已申请
		      @break
		      @case ($item::PRINT)
		      已开票
		      @break
		      @case ($item::SHIP)
		      已发出
		      @break
		      @default
		      未定义
		      @break
		      @endswitch
		    </td>
		    <td>
		      {{ $item->ship_no }}
		    </td>
		    <td>
		      {{ $item->address->contact_name }}
		    </td>
		    <td>
		      {{ $item->admin_name }}
		    </td>
		    <td><a href="{{ route("admin.invoice.edit", $item) }}">编辑</a></td>
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="row">
	  {{ $invoices->appends(["key" => $key, "limit" => $limit])->links() }}
	</div>
      </div>
    </div>
  </div>
@endsection
