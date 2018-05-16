@extends("layouts.admin")

@section("content")
  <form action="{{ route("admin.login") }}" method="POST">
    <p style="color:red">{{ $error }}</p>
    {{ csrf_field() }}
    <p>手机<input name="mobile" type="text" value="" required/></p>
    <p>密码<input name="password" type="password" value="" required/></p>
    <p><input type="submit" value="登录"/></p>
  </form>
@endsection
