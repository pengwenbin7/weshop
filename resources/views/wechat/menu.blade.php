@extends("layouts.wechat")

@section("content")
  <h3>new</h3>
  <form action="{{ route("admin.wechat.menu.store") }}" method="POST">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
    <textarea cols="30" id="" name="buttons" rows="10"></textarea>
    <input type="submit" value="submit">
  </form>
@endsection
