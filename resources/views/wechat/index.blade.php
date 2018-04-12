@extends("layouts.wechat")

@section("content")
  <div id="app">
    <p>user_id: {{ auth()->user()->id }}</p>
    <p><button v-on:click="share">分享到朋友圈</button></p>
    <p><button v-on:click="scan">scan qr</button></p>
    <p><button v-on:click="getLocation">get location</button></p>
    <p>@{{ info }}</p>
    <p><a href="{{ route("wechat.product.index") }}">products</a></p>
  </div>
@endsection

@section("script")
  <script>
  var app = new Vue({
    el: "#app",
    data: {
      info: ""
    },
    methods: {
      share: function () {
	alert("share called");
	wx.onMenuShareTimeline({
	  title: 'share-title', // 分享标题
	  link: 'http://weshop.mafkj.com/1919191919', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
	  imgUrl: '', // 分享图标
	  success: function () {
	    alert("分享成功");
	  },
	  cancel: function () {
	    alert("取消了");
	  }
	});
      },
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
      }
    },
    mounted: function () {
      this.share();
    }
  });

  </script>
@endsection
