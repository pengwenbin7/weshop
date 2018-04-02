@extends("layouts.admin")

@section("content")
  id: {{ $brand->id }}
  <br>
  name: {{ $brand->name }}
  <br>
  logo: {{ $brand->logo }}
  <br>
  sort_order: {{ $brand->sort_order }}
  <br>
  active: {{ $brand->active }}
@endsection
