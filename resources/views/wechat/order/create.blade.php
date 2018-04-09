@extends("layouts.wechat")

@section("content")
  <div id="app">
    <p>
      @if ($user->address)
	TODO: 选择地址
      @else
	<button v-on:click="createAddress">create address</button>	
      @endif
    </p>
    <p>product_id: {{ $product->id }}</p>
    <p>product_name: {{ $product->name }}</p>
    <p>is_ton: {{ $is_ton }}</p>
    <p>
      <button v-on:click="decNumber">-</button>
      number: <input v-model="number" min="1" step="1" type="number">
      @if ($is_ton)
	吨
      @else
	{{ $product->packing_unit }}
      @endif
      <button v-on:click="incNumber">+</button>
    </p>
    <p><button>下载合同</button></p>
    付款方式：
    <ul>
    @foreach ($payChannels as $channel)
      <li>{{ $channel->id }} @@ {{ $channel->name }}</li>
    @endforeach
    </ul>
    
    <button v-on:click="pay">pay</button>
  </div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      number: {{ $number }}
    },
    methods: {
      createAddress: function () {
	alert("TODO: create address");
      },
      decNumber: function () {
	if (this.number > 2) {
	  this.number = this.number - 1;
	} else {
	  alert("Stop!");
	}
      },
      incNumber: function () {
	this.number = this.number + 1;
      },
      pay: function () {
	// call wechat.order.store
      }
    }
  });
  </script>
@endsection
