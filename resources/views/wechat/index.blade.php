@extends("layouts.wechat")

@section("content")
	
		<div class="container">
		<div class="index" id="app">
		<div class="header">
			<div class="logo">
				<img src="http://www.taihaomai.com/themes/default/images/logo2.png" />
			</div>
			<div class="title">
				<h2>直接搜货</h2>
			</div>
		</div>
			<div class="search">
				<div class="i-search">
					<form action="{{ route("wechat.search") }}" method="get">
						<input type="text" name="keyword" id="keyword" value="" placeholder="输入关键词快速查找商品" />
						<input class="btn-submit" type="submit" value="找货"/>
					</form>
				</div>
				<div class="hot-search">
					<div class="title">
						<span>热门搜索</span>
					</div>
					<div class="h-list">
						<a href="">钛白粉</a>
						<a href="">炭黑</a>
						<a href="">三项方</a>
						<a href="">杜邦</a>
						<a href="">PVC</a>
						<a href="">钛白粉</a>
						<a href="">炭黑</a>
						<a href="">三项方</a>
						<a href="">杜邦</a>
						<a href="">PVC</a>
					</div>
				</div>
			</div>
			
			<div class="products" id="product" >
				<div class="title">
							<span>热卖商品</span>
				</div>
				@foreach($products as $product)
				<div class="product">
					<a href="{{ route("wechat.product.show", 1) }}">
						<div class="prop">
							<p class="black"><span class="p-name">{{ $product->product->name }}</span>
								<span class="p-model"></span></p>
							<p class="gray"><span class="p-bname"></span></p>
						</div>
						<p class="pirce">
							<span class="y"><i>￥</i>12222元/吨</span>
						</p>
					</a>
				</div>
				@endforeach
				<div class="product">
					<a href="{{ route("wechat.product.show", 1) }}">
						<div class="prop">
							<p class="black"><span class="p-name">真石漆质感漆乳液 </span>
								<span class="p-model">LR-9611</span></p>
							<p class="gray"><span class="p-bname">恒和化工</span></p>
						</div>
						<p class="pirce">
							<span class="y"><i>￥</i>12222元/吨</span>
						</p>
					</a>
				</div>
				
			</div>
		</div>
		
	</div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
          items: [{
              brand: '恒和化工',
              name: '真石漆质感漆乳液 ',
              model: 'LR-9611',
              price: '79999'
          },
          {
              brand: '振洲涂料',
              name: '丙烯酸改性乳液',
              model: 'A-98',
              price: '8600'
          },
          {
              brand: '紫石化工',
              name: '木器底漆乳液',
              model: 'ZS-6808A',
              price: '10800'
          },{
              brand: '佰利联2',
              name: '氧化铁',
              model: 'BLT-0011011',
              price: '79999'
          },{
              brand: '佰利联2',
              name: '氧化铁',
              model: 'BLT-0011011',
              price: '79999'
            }

          ]
        },
    methods: {
      scan: function () {
	wx.scanQRCode({
	  needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
	  scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
	  success: function (res) {
	    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
	    alert(result);
	  }
	});
      },

      getLocation: function () {
	var _this = this;
	wx.getLocation({
	  type: 'wgs84',
	  success: function (res) {
	    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	    var speed = res.speed; // 速度，以米/每秒计
	    var accuracy = res.accuracy; // 位置精度
	    _this.info = "Lat:" + latitude + "Long:" + longitude;
	  }
	});
      },

      getAddress: function () {
	wx.openAddress({
	  success: function (res) {
	    axios.post(
	      "{{ route("wechat.address.store") }}",
	      res
	    ).then( function (res) {
	      alert(res.data);
	    });
	  },
	  cancel: function () {
	    alert("取消");
	  }
	});
      }
    },
    mounted: function () {
      // todo
    }
  });

  </script>
@endsection
