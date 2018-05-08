@extends("layouts.wechat")

@section("content")
  <div id="app">
    <p>
      <p>
	addr_id: <input type="number" v-model="address_id">
	<button v-on:click="selectAddress">select address</button>
      </p>
      
      @foreach ($products as $product)
	<p>product_id: {{ $product->id }}</p>
	<p>product_name: {{ $product->name }}</p>
	<p>is_ton:<input v-model="is_ton" type="number">
	  <p>
	    show_number: <input v-model="show_number" min="1" step="1" type="number">
	    <p>number: @{{ number }}</p>
	    @if ($product->is_ton)
	      吨
	    @else
	      {{ $product->packing_unit }}
	    @endif
	  </p>
      @endforeach
      
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
      show_number: 1,
      address_id: null,
      channel_id: 1,
      freight: 0
    },

    computed: {
      number: function () {
	return 0 == this.is_ton?
	  this.show_number:
	  this.show_number * 1000 / {{ $product->content }};
      }
    },
    
    methods: {
      // storage default freight function
      storageFunc: function () {
	var func = JSON.parse('{!! $product->storage->func !!}');
      },
      
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
	    {id: {{ $product->id }}, number: $this.number}
	  ]
	};
	axios.post("{{ route("wechat.order.count-freight") }}",
	  data).then(function (res) {
	    $this.freight = res.data;
	  });
      }
    },

    mounted: function () {
    }

  });
  </script>
@endsection
