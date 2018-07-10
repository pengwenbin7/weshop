<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<title>{{ $title ?? "Admin" }}</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset("assets/css/app.css") }}" rel="stylesheet">
	<link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/AdminLTE.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/skins/skin-blue.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/select2/4.0.6-rc.1/css/select2.min.css" rel="stylesheet">
	<style>
		input:required, select:required, textarea:required {
			border-color: #EE7777;
		}
		[v-cloak] {
			display: none;
		}
	</style>
	@yield("style")
</head>
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
								<th>业务员</th>
								<th>电话</th>
								<th>职位</th>
								<th style="text-align:center">操作</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($user as $item)
								<tr role="row">
									<td>{{ $serial++ }}</td>
									<td id="name_id{{ $item->id }}">{{ $item->name }}</td>
									<td>{{ $item->mobile }}</td>
									<td>{{ $item->position }}</td>
									<td style="text-align:center"><input type="radio" id="checkid{{ $item->id }}" name="user" value="{{ $item->id }}" onclick="check({{ $item->id }})"></td>
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
				<div class="col-sm-6">{{ $user->appends(["limit" => $limit, "name" => $name, "id" => $id])->links() }}<div style="height:100%;lone-height:100%"> 总共：{{ $line_num }}</div></div>
			<input type="hidden" id="userid" value="{{ $id }}">
			</div>
		</div>
	</div>
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
<script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/admin-lte/2.4.3/js/adminlte.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/select2.min.js"></script>
<script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/i18n/zh-CN.js"></script>
  <script>
      {{--function check(obj) {--}}
          {{--var id = $("#userid").val();--}}
          {{--var name = $("#name_id" + obj).text();--}}
          {{--//判断当前是否选中--}}
          {{--if ($("#checkid" + obj).is(':checked')) {--}}
              {{--var onurl = "{{ route('admin.shopuser.modifying') }}";--}}
              {{--var data = {id: id, admin_id: obj};--}}
              {{--axios.post(onurl, data)--}}
                  {{--.then(function (res) {--}}
                      {{--if (res.status == 200) {--}}
                          {{--var p = res.data;--}}
                          {{--if (p.status == 'ok') {--}}
                              {{--parent.document.getElementById("user_id"+id).innerHTML = name;--}}
                              {{--var index = parent.layer.getFrameIndex(window.name); //获取窗口索引--}}
                              {{--parent.layer.close(index);--}}
                          {{--} else {--}}
                              {{--return layer.msg("操作失败，请重新选择！");--}}
                          {{--}--}}
                      {{--} else {--}}
                          {{--return layer.msg("操作失败，请重新选择！");--}}
                      {{--}--}}
                  {{--})--}}
          {{--}--}}
      {{--}--}}
      function check(obj) {
          var id = $("#userid").val();
          var name = $("#name_id" + obj).text();
          //判断当前是否选中
          if ($("#checkid" + obj).is(':checked')) {
              var onurl = "{{ route('admin.shopuser.modifying') }}";
              var data = {id: id, admin_id: obj};
              axios.post(onurl, data)
                  .then(function (res) {
                      if (res.status == 200) {
                          var p = res.data;
                          if (p.status == 'ok') {
                              //数组
                              var arr = id.split(",");
                              for (p in arr) {
                                  parent.document.getElementById("user_id"+arr[p]).innerHTML = name;
                              }
                              var coll = parent.document.getElementsByName("userid");
                              parent.document.getElementById("user_check").checked = false;
                              for (var i = 0; i < coll.length; i++) {
                                  coll[i].checked = false;
							  }
                              var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                              parent.layer.close(index);
                          } else {
                              return layer.msg("操作失败，请重新选择！");
                          }
                      } else {
                          return layer.msg("操作失败，请重新选择！");
                      }
                  })
          }
      }
  </script>
