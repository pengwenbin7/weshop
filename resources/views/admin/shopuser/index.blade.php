@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">所有用户</h3>
      <h3 class="box-title">
	{{--<a href="{{ route("admin.product.create",['limit' => $limit, 'name' => $name]) }}">添加</a>--}}
      </h3>
    </div>
    <div class="box-body">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
	<div class="row">
	  <div class="col-sm-6">
	    <div class="dataTables_length">
	      <form action="{{ url()->current() }}" id="form-start">
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
		  <input class="form-control input-sm" name="name" value="{{ $name }}" placeholder="" type="search">
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
		  <th>用户名称</th>
		  <th>积分</th>
		  <th>业务员</th>
		  <th>关注时间</th>
		  {{--<th>操作</th>--}}
		</tr>
	      </thead>
	      <tbody>
		@foreach ($user as $item)
		  <tr role="row">
		    <td>{{ $serial++ }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ $item->integral }}</td>
			  <td><span id="user_id{{ $item->id }}">{{ $item->admin->name }}</span><div style="float:right;cursor:pointer;" onclick="edituser('{{ route("admin.shopuser.create",['id' => $item->id]) }}')">……</div></td>
		    <td>{{ date("Y-m-d H:i:s",$item->subscribe_time) }}</td>
		    {{--<td>--}}
		      {{--<a href="{{ route("admin.product.edit", ['item' => $item, 'limit' => $limit, 'name' => $name]) }}">编辑</a>--}}
		      {{--&nbsp;|&nbsp;--}}
		      {{--<a href="{{ route("admin.product.show", $item) }}">详细</a>--}}
		    {{--</td>--}}
		  </tr>
		@endforeach
	      </tbody>
	    </table>
	  </div>
	</div>

      </div>
    </div>
    <div class="box-footer">
      <div class="row">
		  <div class="col-sm-6">{{ $user->appends(["limit" => $limit, "name" => $name])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div></div>
      </div>
    </div>
  </div>
  <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
  <script>
  function edituser(url){
      var w = $("body").width() - 600 + 'px';
      var h = $("body").height() - 600 + 'px';
      //iframe窗
      layer.open({
          type: 2,
          title: false,
          closeBtn: 2, //不显示关闭按钮
          shift: 7,
          shade: [0],
          area: [w, h],
          content: [url],

      });
  }

  </script>
@endsection
