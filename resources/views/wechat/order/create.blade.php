@extends("layouts.wechat")

@section("content")
  <div id="app">
    <p>
      <p>
	addr_id: <input type="number" v-model="address_id">
	<button v-on:click="selectAddress">select address</button>
      </p>
    <p>product_id: {{ $product->id }}</p>
    <p>product_name: {{ $product->name }}</p>
    <p>is_ton:<input v-model="is_ton" type="number">
      <p>
	number: <input v-model="show_number" min="1" step="1" type="number">
	<div v-if="is_ton">
	  <p>number: @{{ show_number * factor }}</p>
	</div>
	<div v-else>
	  <p>number: @{{ show_number }}</p>
	</div>
	@if ($product->is_ton)
	  吨
	@else
	  {{ $product->packing_unit }}
	@endif
      </p>
      <p><button>下载合同</button></p>
      <p v-if="address_id">
	<button v-on:click="countFreight">count freight</button>
	<b>freight: @{{ freight }}</b>
      </p>
      付款方式：
      <select v-model="channel_id">
	@foreach ($payChannels as $channel)
	  <option value="{{ $channel->id }}">
	    {{ $channel->name }}
	  </option>
	@endforeach
      </select>
      <div v-if="address_id">
	<button v-on:click="pay">pay</button>
      </div>
      <div v-else>
	<button disabled>pay</button>
      </div>
  </div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      is_ton: {{ $product->is_ton }},
      show_number: {{ $number }},
      number: 0,
      address_id: null,
      factor: {{ 1000 / $product->content }},
      channel_id: 1,
      freight: 0
    },
    methods: {
      selectAddress: function () {
	var $this = this;
	wx.openAddress({
	  success: function (res) {
	    axios.post(
	      "{{ route("wechat.address.store") }}",
	      res
	    ).then(function (res) {
	      $this.address_id = res.data.address_id;
	    });
	  },
	  cancel: function () {
	    alert("取消");
	  }
	});
      },
      
      pay: function () {
	var data = {
	  address_id: this.address_id,
	  channel_id: this.channel_id,
	  products: [
	    {
	      number: this.number,
	      is_ton: this.is_ton,
	      id: {{ $product->id }}
	    }
	  ]
	};
	axios.post("{{ route("wechat.order.store") }}", data)
	  .then(function (res) {
	    location.assign("{{ route("wechat.pay") }}" +
	      "/?order_id=" + res.data.store);
	  });
      },
      
      countFreight: function () {
	var $this = this;
	var data = {
	  address_id: this.address_id,
	  products: [
	    {id: {{ $product->id }}, number: this.number}
	  ]
	};
	axios.post("{{ route("wechat.order.count-freight") }}",
	  data).then(function (res) {
	    $this.freight = res.data;
	  });
      }
    },
    
    mounted: function () {
      this.number = this.is_ton ?
	this.show_number * this.factor :
	this.show_number;
    }
      
  });
  </script>
@endsection
