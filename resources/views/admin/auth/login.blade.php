@extends("layouts.app")

@section("style")
  <style>
  </style>
@endsection

@section("content")
  <div class="container-fluid" id="app">
    <div class="col-md-6 col-md-offset-3">
      <div class="box box-info">
	<div class="box-header with-border">
          <h3 class="box-title">登录</h3>
	</div>
	<form class="form-horizontal" action="{{ route("admin.login") }}" method="POST">
	  {{ csrf_field() }}
          <div class="box-body">
            <div class="form-group">
              <label for="mobile" class="col-sm-2 control-label">手机</label>
              <div class="col-sm-10">
		<input class="form-control" id="mobile" name="mobile" type="text" value="" required>
              </div>
            </div>

	    <div class="form-group">
              <label for="password" class="col-sm-2 control-label">密码</label>
              <div class="col-sm-10">
		<input class="form-control" id="password" name="password" type="password" value="" required/>
              </div>
            </div>

	    <div class="form-group">
	      <div class="col-sm-10 col-sm-offset-2 alert alert-warning" role="alert">
		{{ $error ?? "" }}
              </div>
            </div>
	    
	  </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-info btn-block">登录</button>
          </div>
	</form>
      </div>
    </div>
  </div>
  <script>
  </script>
@endsection

@section("script")
@endsection
