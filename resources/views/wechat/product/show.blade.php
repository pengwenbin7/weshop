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
      <input v-model="number" type="number" min="1" step="1">
      <button v-on:click="addToCart">add to cart</button>
      <button v-on:click="directlyBuy">direct buy</button>
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
      is_ton: 0
    },
    methods: {
      addToCart: function () {
	var params = {
	  product_id: "{{ $product->id }}",
	  number: this.number,
	  is_ton: this.is_ton
	};
	axios.post("{{ route("wechat.cart.store") }}", params)
	  .then(function (res) {
	    console.log(res.data);
	  });
      },
      directlyBuy: function () {
	console.log("BUY");
	var params = {
	  product_id: "{{ $product->id }}",
	  number: this.number,
	  is_ton: this.is_ton
	};
	location.assign("{{ route("wechat.order.create") }}" +
	  "?product_id=" + {{ $product->id }} + 
	  "&number=" + this.number +
	  "&is_ton=" + this.is_ton);
      }
    }
  });
  </script>
@endsection
