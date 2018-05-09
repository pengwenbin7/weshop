@extends("layouts.wechat")

@section("content")
  @foreach ($carts as $item)
    <h1>id{{ $item->id }}</h1>
  @endforeach
@endsection
