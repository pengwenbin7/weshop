@extends("layouts.wechat")

@section("style")
  <style>
  div {
    border: 1px solid red;
  }
  </style>
@endsection

@section("content")
  
  <div id="app">
    @foreach ($categories as $category)
      <a href="#{{ $category->id }}">{{ $category->name }}</a>
    @endforeach
    <p>###########</p>
    @foreach ($brands as $brand)
      <a href="#{{ $brand->id }}">{{ $brand->name }}</a>
    @endforeach
    <p>###########</p>
    
    @foreach ($products as $product)
      <div>
	name: {{ $product->name }}
	<br>
	brand_name: {{ $product->brand->name }}
	<br>
	仓库: {{ $product->storage->name }}
	<br>
	@if ($product->is_ton)
	  吨价: {{ $product->variable->unit_price * 1000 / $product->content }}
	@else
	  单价: {{ $product->variable->unit_price }}
	@endif
	<a href="{{ route("wechat.product.show", $product->id) }}">see detail</a>
      </div>
    @endforeach
    {{ $products->links() }}
  </div>
@endsection
