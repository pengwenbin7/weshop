@extends("layouts.wechat")

@section("content")
  <div id="app">
    <ul>
      @foreach ($user->orders as $order)
	<li>{{ $order->no }}</li>
      @endforeach
    </ul>
  </div>
@endsection
