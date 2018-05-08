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
      @if (auth()->user()->carts->isNotEmpty())
	<select v-model="cart_id">
	  @foreach (auth()->user()->carts as $cart)
	    <option value="{{ $cart->id }}">{{ $cart->address->getText() }}</option>
	  @endforeach
	</select>
	新建采购单:
	<button v-on:click="createCart">createCart</button>
      @else
	新建采购单:
	<button v-on:click="createCart">createCart</button>
      @endif

      <button v-on:click="addToCart">add to cart</button>
      <button v-on:click="buyMe">buy me</button>
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
	      var d = {
		address_id: res.data.address_id
	      };
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
	  product_id: "{{ $product->id }}"
	};
	axios.post("{{ route("wechat.cart.add_product") }}", params)
	  .then(function (res) {
	    alert(res.data.add);
	  });
      },
      buyMe: function () {
	location.assign("{{ route("wechat.product.buyme") }}" +
	  "?product_id={{ $product->id }}"
	);
      }
    }
  });
  </script>
@endsection
