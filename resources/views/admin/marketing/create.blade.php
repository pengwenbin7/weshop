@extends("layouts.admin")

@section("content")
  <div class="col-md-6">
    <div class="box box-info">
      <div class="box-header with-border">
	<h3 class="box-title"><a href="{{ route("admin.marketing.index") }}">推送消息列表</a></h3>
	<h3 class="box-title">添加</h3>
      </div>
      <form class="form-horizontal" action="{{ route("admin.marketing.store") }}" method="POST">
	<div class="box-body">
	  {{ csrf_field() }}
          <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">标题</label>
	    <div class="col-sm-10">
	      <input class="form-control" id="title" name="title" type="text">
            </div>
	  </div>

		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">业务类型</label>
			<div class="col-sm-10">
				<input class="form-control" id="text_type" name="text_type" type="text" required>
			</div>
		</div>

		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">变更结果</label>
			<div class="col-sm-10">
				<input class="form-control" id="result" name="result" type="text" required>
		    </div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">结尾说明</label>
			<div class="col-sm-10">
				<input class="form-control" id="ending" name="ending" type="text">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">链接</label>
			<div class="col-sm-10">
				<input class="form-control" id="link" name="link" type="text" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">发送对象</label>
			<div class="col-sm-10">
				<select class="form-control select2" name="user_type" required>
					<option value="10086">请选择对象类型</option>
					<option value="2">星标用户</option>
					<option value="102">下游客户</option>
					<option value="107">供应商</option>
					<option value="105">同行及其他</option>
					<option value="108">未知可发</option>
					<option value="109">调价消息推送</option>
					<option value="100">马峰</option>
				</select>
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

@section("script")
  <script>

  </script>
@endsection
