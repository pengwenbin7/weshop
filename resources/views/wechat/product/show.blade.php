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
      @if (auth()->user()->carts->isEmpty())
	新建采购单:
	<button v-on:click="createCart">createCart</button>
      @else
	<select name="cart_id">
	  @foreach (auth()->user()->carts as $cart)
	    <option value="{{ $cart->id }}">{{ $cart->address->id }}</option>
	  @endforeach
	</select>
      @endif

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
      cart_id: null,
      cart_addr: null,
    },
    methods: {
      createCart: function () {
	var $this = this;
	wx.openAddress({
	  success: function (res) {
	    axios.post(
	      "{{ route("wechat.address.store") }}",
	      res
	    ).then(function (res) {
	      var url = "{{ route("wechat.cart.store") }}";
	      var d = new FormData();
	      d.set("address_id", res.data.address_id);
	      d.set("_token", "{{ csrf_token() }}");
	      axios.post(url, d).
		then(function (res) {
		  location.reload();
		});
	    });
	  },
	  cancel: function () {
	    //
	  }
	});
      },
      addToCart: function () {
	var params = {
	  cart_id: this.cart_id,
	  product_id: "{{ $product->id }}",
	  number: this.number
	};
	axios.post("{{ route("wechat.cart.store") }}", params)
	  .then(function (res) {
	    console.log(res.data);
	  });
      },
      directlyBuy: function () {
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
