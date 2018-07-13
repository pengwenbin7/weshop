@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">我的用户</h3>
      <h3 class="box-title">
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
          公司认证
          <select name="company" class="form-control input-sm">
              <option value="1" {{ $company == 1 ? 'selected':'' }}>全部</option>
              <option value="2" {{ $company == 2 ? 'selected':'' }}>已认证</option>
          </select>
        </label>
		<label>
		  <input class="form-control input-sm" name="name" value="{{ $name }}" placeholder="用户昵称/业务员" type="search">
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
		  <th>昵称</th>
		  <th>个人信息</th>
		  <th>积分</th>
		  <th>业务员</th>
          @if (auth("admin")->user()->can("vip"))
          <th style="text-align:center">VIP状态</th>
          @endif
		  <th>关注时间</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($user as $item)
		  <tr role="row">
		    <td>{{ $serial++ }}</td>
		    <td>{{ $item->name }}</td>
            <td><div>{{ isset($item->company->name) ? $item->company->name:'' }}</div>
              {{ isset($item->lastAddress->contact_name) ? $item->lastAddress->contact_name:''}}
              <a href="tel:{{ isset($item->lastAddress->contact_tel) ? $item->lastAddress->contact_tel:''}}">
                  {{ isset($item->lastAddress->contact_tel) ? $item->lastAddress->contact_tel:''}}</a><br>
              @if(isset($item->lastAddress))
                  {{ isset($item->lastAddress->province) ? $item->lastAddress->province:''}}
                  {{ isset($item->lastAddress->district) ? $item->lastAddress->district:''}}<br>
              @endif
            </td>
		    <td>{{ $item->integral }}</td>
		    <td>{{ $item->admin->name }}</td>
            @if (auth("admin")->user()->can("vip"))
            <td style="text-align:center;">
            @if($item->is_vip == false)
            <a style="cursor:pointer;color:#636B6F;" onclick="vipreset({{ $item->id }},1)" id="str{{ $item->id }}">否</a>
            @else
            <a style="cursor:pointer;color:#636B6F" onclick="vipreset({{ $item->id }},2)" id="str_str{{ $item->id }}">是</a>
            @endif
            </td>
          @endif
		    <td>{{ date("Y-m-d H:i:s",$item->subscribe_time) }}</td>
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
		  <div class="col-sm-6">{{ $user->appends(["limit" => $limit, "name" => $name, 'company'=>$company])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div></div>
      </div>
    </div>
  </div>
  <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
  <script>
  //修改vip状态
  function vipreset(obj,status)
  {
      var str = '';
      if (status == 1) {
          str = "确认设置vip?";
      } else {
          str = "确认取消vip?";
      }
      layer.confirm(str, {
          btn: ['是','否'] //按钮
      }, function(){
          layer.closeAll();
          var data = {id:obj,status:status};
          var onurl = "{{ route('admin.meuser.create') }}";
          axios.post(onurl,data)
              .then(function (res) {
                  if (res.status == 200) {
                      var p = res.data;
                      if (p.status == 'ok') {
                          layer.msg('修改成功！', {time:500},function (index) {
                              layer.close(index);
                              window.location.href='{{ route('admin.meuser.index') }}';
                          });
                      }else{
                          layer.msg('修改失败！');
                      }
                  } else {
                      layer.msg('修改失败！');
                  }
              })
      });
  }

  </script>
@endsection
