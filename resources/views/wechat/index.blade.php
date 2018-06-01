@extends( "layouts.wechat")

@section( "content")

  <div class="container">
    <div class="index" id="app">
      <div class="search">
	<div class="i-search">
    <a  href="{{ route("wechat.search") }}">
	    <input type="text" name="keyword" id="keyword" value="" placeholder="输入关键词快速查找商品" />
	    <input class="btn-submit" type="submit" value="找货" />
      </a>
	</div>
	<div class="hot-search" v-on:click="getAddress">
	  <div class="title">
	    <span>热搜</span>
	  </div>
    <div class="h-list">
    @foreach ($hot_search as $item)
      <a href="{{ route("wechat.search") }}?keyword={{ $item->keyword }}">{{ $item->keyword }}</a>
    @endforeach


	  </div>
	</div>
      </div>

      <div class="products" id="product">
	<div class="title">
	  <span>热卖</span>
	</div>
	@foreach($products as $product)
	  <div class="product">
	    <a href="{{ route("wechat.product.show", $product->id) }}">
	      <div class="prop">
		<p class="black">
		  <span class="p-name">{{ $product->product->name }}</span>
		  <span class="p-model">{{ $product->product->model }}</span>
		</p>
		<p class="gray">
		  <span class="p-bname">{{ $product->product->brand->name }}</span>
		</p>
		<p class="pirce">
		  @if($product->product->is_ton)
		    <span class="y"><i>￥</i>{{ $product->product->variable->unit_price*1000/$product->product->content }}/吨</span>
		  @else
		    <span class="y"><i>￥</i>{{ $product->product->variable->unit_price }}/{{ $product->product->packing_unit }}</span>
		  @endif
		</p>
	      </div>
	    </a>
	  </div>
	@endforeach


      </div>
    </div>

  </div>
@endsection

@section( "script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
     
    },
    methods: {
      scan: function() {
	wx.scanQRCode({
	  needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
	  scanType: ["qrCode", "barCode"], // 可以指定扫二维码还是一维码，默认二者都有
	  success: function(res) {
	    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
	    alert(result);
	  }
	});
      },

      getLocation: function() {
	var _this = this;
	wx.getLocation({
	  type: 'wgs84',
	  success: function(res) {
	    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	    var speed = res.speed; // 速度，以米/每秒计
	    var accuracy = res.accuracy; // 位置精度
	    _this.info = "Lat:" + latitude + "Long:" + longitude;
	  }
	});
      },

      getAddress: function() {
	wx.openAddress({
	  success: function(res) {
	    alert(JSON.stringify(res))
	      axios.post(
		"{{ route("wechat.address.store") }}",res)
	      .then(function(res) {
		alert(res.data);
	      });
	  },
	  cancel: function() {
	    alert("取消");
	  }
	});
      }
    },
    mounted: function() {
      // todo
    }
  });
  </script>
@endsection
