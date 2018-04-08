@extends("layouts.app")

@section("style")
  <style>
  div: {
    border: 1px solid red;
  }
  </style>
@endsection

@section("content")
  <p>user: {{ auth()->user()->id }}</p>
  @foreach ($products as $product)
    <div>
      name: {{ $product->name }}
      <br>
      brand_name: {{ $product->brand->name }}
      <br>
      仓库: {{ $product->storage->name }}
      <br>
      @if ($product->is_ton)
	单价: {{ $product->price()->unit_price }}
      @else
	吨价: {{ $product->price()->ton_price }}
      @endif
    </div>
  @endforeach
  {{ $products->links() }}

@endsection
