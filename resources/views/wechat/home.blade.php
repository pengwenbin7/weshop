@extends("layouts.wechat")

@section("content")
  <div id="app">
    <a href="{{ route("wechat.address.create") }}">
      create_address
    </a>
  </div>
@endsection
