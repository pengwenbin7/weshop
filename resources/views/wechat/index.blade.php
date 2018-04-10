@extends("layouts.wechat")

@section("content")
  <p>user_id: {{ session("wechat_user")->id }}</p>
  <p><button id="share">分享到朋友圈</button></p>
  <p><button id="scan">scan qr</button></p>
  <p><button id="location">get location</button></p>
  <p id="location_info"></p>
@endsection

@section("script")
  <script>
  $("#share").click(function () {
    alert("clicked");
    wx.onMenuShareAppMessage({
      title: '互联网之子',
      desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
      link: 'http://movie.douban.com/subject/25785114/',
      imgUrl: 'http://demo.open.weixin.qq.com/jssdk/images/p2166127561.jpg',
      trigger: function (res) {
        alert('用户点击发送给朋友');
      },
      success: function (res) {
        alert('已分享');
      },
      cancel: function (res) {
        alert('已取消');
      }
    });
  });

  $("#scan").click(function () {
    wx.scanQRCode({
      needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
      scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
      success: function (res) {
	var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
	alert(result);
      }
    });
  });

  $("#location").click(function () {
    wx.getLocation({
      type: 'wgs84',
      success: function (res) {
	var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
	var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
	var speed = res.speed; // 速度，以米/每秒计
	var accuracy = res.accuracy; // 位置精度
	$("#location_info").text("Lat:" + latitude + "Long:" + longitude);
      }
    });
  });
  
  </script>
@endsection
