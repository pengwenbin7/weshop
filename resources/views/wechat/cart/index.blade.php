@extends("layouts.wechat")

@section("content")

  @foreach ($items as $item)
    <h1>id{{ $item->id }}</h1>
  @endforeach
@endsection
