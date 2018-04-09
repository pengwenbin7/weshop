@extends("layouts.wechat")

@section("style")
@endsection

@section("content")
  <div id="app">
    <p>product id: {{ $product->id }}</p>
    <p>name: {{ $product->name }}</p>
    <p>brand name: {{ $product->brand->name }}</p>
    <p>brand id: {{ $product->brand->id }}</p>
    <p>storage name: {{ $product->storage->name }}</p>
    <p>is ton: {{ $product->is_ton }}</p>
    <p>unique code: {{ $product->unique_code }}</p>
    <p>pack: {{ $product->pack() }}</p>
    <p>unit price: {{ $product->variable->unit_price }}</p>
    <p>stock: {{ $product->variable->stock }}</p>
    <p>buy: {{ $product->variable->buy }}</p>
    <div>
      <input v-model="number" type="number" min="1" value="1" step="1">
      <button class="add" data-number=" @{{ number }} ">add to cart</button>
      <input v-model="message">
      @{{ message }}
    </div>
    <p>detail: {{ $product->detail->content }}</p>
    history prices :
    <ul>
      @foreach ($product->prices as $price)
	<li>
	  time: {{ $price->created_at }} @@ unit_price: {{ $price->unit_price }}
	</li>
      @endforeach
    </ul>
  </div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      number: 1,
      message: "hello world"
    }
  });
  </script>
@endsection
