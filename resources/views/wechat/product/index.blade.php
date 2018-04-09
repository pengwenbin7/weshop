@extends("layouts.wechat")

@section("style")
  <style>
  div {
    border: 1px solid red;
  }
  </style>
@endsection

@section("content")
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

@endsection
