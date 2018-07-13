@extends("layouts.admin")

@section("content")

  <div class="box">
    <div class="box-header">
      <h3 class="box-title">公众号—消息推送</h3>
      <h3 class="box-title">
	<a href="{{ route("admin.marketing.create",['limit' => $limit, 'name' => $name]) }}">添加</a>
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
		  <input type="hidden" name="active" value="{{ $active }}" id="active">
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
		  <th>标题</th>
		  <th>业务类型</th>
		  <th>变更结果</th>
		  <th>时间</th>
		  <th>结尾声明</th>
		  <th>链接</th>
		  <th>用户分类</th>
		  <th>操作</th>
		</tr>
	      </thead>
	      <tbody>
		@foreach ($Marketing as $item)
		  <tr role="row">
		    <td>{{ $serial++ }}</td>
		    <td>{{ $item->title }}</td>
		    <td>{{ $item->text_type }}</td>
		    <td>{{ $item->result }}</td>
		    <td>{{ $item->created_at }}</td>
		    <td>{{ $item->ending }}</td>
		    <td>{{ substr($item->link,0,6) }}</td>
		    <td>{{ $item->products($item->user_type) }}</td>
		    <td>
		      <a href="{{ route("admin.marketing.edit", $item) }}">编辑</a>
		      &nbsp;|&nbsp;
		      <a style="cursor:pointer;" onclick="show({{ $item->id }})">发送</a>
{{--		      <a href="{{ route("admin.marketing.show", $item) }}">发送</a>--}}
                &nbsp;|&nbsp;
              <a style="cursor:pointer;" onclick="del({{ $item->id }})">删除</a>
			</td>
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
		  <div class="col-sm-6">{{ $Marketing->appends(["limit" => $limit, "name" => $name,'active' => $active])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div></div>
      </div>
    </div>
  </div>
  <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdn.bootcss.com/layer/3.1.0/layer.js"></script>
  <script>
      //删除
      function del(id){
          layer.confirm('是否删除？', {
              btn: ['是','否'] //按钮
          }, function(){
              layer.closeAll();
              var onurl = "{{ route('admin.marketing.delete') }}";
              var data = {id:id};
              axios.post(onurl,data)
                  .then(function (res) {
                      if (res.status == 200) {
                          var p = res.data;
                          if (p.status == 'ok') {
                              layer.msg('删除成功！', {time:500},function (index) {
                                  layer.close(index);
                                  window.location.href='{{ route('admin.marketing.index') }}';
                              });
                          } else {
                              return layer.msg('删除失败！');
                          }
                      } else {
                          return layer.msg('删除失败！');
                      }
                  })
          });
      }
      //发送
      function show(id){
          layer.confirm('是否发送？', {
              btn: ['是','否'] //按钮
          }, function(){
              layer.closeAll();
              var data = {id:id};
              var onurl = "{{ route('admin.marketing.show') }}";
              axios.post(onurl,data)
                  .then(function (res) {
                      if (res.status == 200) {
                          var p = res.data;
                          if (p.status == 'ok') {
                              layer.msg('发送成功！');
                          }
                      }
                  })
          });
      }


  </script>
@endsection
