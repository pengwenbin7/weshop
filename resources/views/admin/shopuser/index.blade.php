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
		<div class="col-sm-4" style="">
		</div>
		<div class="col-sm-1" style="">
			<div class="input-group">
			    <button class="btn btn-sm btn-primary" onclick="userall('{{ route("admin.shopuser.create") }}')">选择业务员</button>
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
		  <th>姓名</th>
		  <th>电话</th>
		  <th>地址</th>
		  <th>积分</th>
		  <th>业务员</th>
          @if (auth("admin")->user()->can("vip"))
          <th style="text-align:center">VIP状态</th>
          @endif
		  <th>关注时间</th>
		  <th style="text-align:center">全部<input type="checkbox" id="user_check" onclick="user_check()"></th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($user as $item)
		  <tr role="row">
		    <td>{{ $serial++ }}</td>
		    <td>{{ $item->name }}</td>
		    <td>{{ isset($item->lastAddress->contact_name) ? $item->lastAddress->contact_name:''}}</td>
              <td><a href="tel:{{ isset($item->lastAddress->contact_tel) ? $item->lastAddress->contact_tel:''}}">{{ isset($item->lastAddress->contact_tel) ? $item->lastAddress->contact_tel:''}}</a></td>
		    <td>{{ isset($item->lastAddress->province) ? $item->lastAddress->province:''}}</td>
		    <td>{{ $item->integral }}</td>
			<td><span id="user_id{{ $item->id }}">{{ $item->admin->name }}</span><div style="float:right;cursor:pointer;" onclick="edituser('{{ route("admin.shopuser.create",['id' => $item->id]) }}')">……</div></td>
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
		    <td style="text-align:center"><input type="checkbox" name="userid" value="{{ $item->id }}"></td>
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
  //全选全不选
  function user_check(){
      var collid = document.getElementById("user_check");
      var coll = document.getElementsByName("userid");
      if (collid.checked){
          for (var i = 0; i < coll.length; i++)
              coll[i].checked = true;
      } else {
          for (var i = 0; i < coll.length; i++)
              coll[i].checked = false;
      }
  }
  function userall(obj){
      layer.confirm('确认进行批量修改？', {
          btn: ['是','否'] //按钮
      }, function(){
          layer.closeAll();
          pobj = document.getElementsByName("userid");
          checkg_val = [];
          for (f in pobj){
              if(pobj[f].checked)
                  checkg_val.push(pobj[f].value);
          }
          //过滤批量数据中特殊字符
          for(var i = 0 ;i<checkg_val.length;i++)
          {
              if(checkg_val[i] == "on" || typeof(checkg_val[i]) == "undefined")
              {
                  checkg_val.splice(i,1);
                  i= i-1;
              }
          }
          var group = checkg_val;
          if(group == ''){
              return layer.msg("请选择要修改的用户！");
          }
          var url = obj+"?id="+group;
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
      });
  }
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
          var onurl = "{{ route('admin.shopuser.store') }}";
          axios.post(onurl,data)
              .then(function (res) {
                  if (res.status == 200) {
                      var p = res.data;
                      if (p.status == 'ok') {
                          layer.msg('修改成功！', {time:500},function (index) {
                              layer.close(index);
                              window.location.href='{{ route('admin.shopuser.index') }}';
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
