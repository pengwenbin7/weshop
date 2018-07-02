<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <title>{{ $title ?? "weshop" }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <link rel="stylesheet" href="{{ asset("assets/css/reset.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/css/style.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/font/iconfont.css") }}">
    <style media="screen">
      [v-cloak] {
        display: none;
      }
    </style>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <script type="text/javascript">
    var fSize=(document.documentElement.clientWidth/7.5)>100?100:(document.documentElement.clientWidth/7.5);document.documentElement.style.fontSize = fSize + "px";window.addEventListener("orientationchange", function() { location.reload(); }, false);
    </script>

    @yield("style")
  </head>
  <body style="background-color:#f0f1f0">
    @yield("content")
    @if(auth()->user()->is_subscribe < 1)
    <div class="subscribe" onclick="showSubscribeBox()">
      点击关注<br>了解更多
    </div>
    <div class="subscribe-box" id="subscribe_box">
      <div class="item">
        <p class="tit">需关注后才能选购</p>
        <img src="{{ asset("assets/img/qrcode.png") }}" alt="">
        <p>[长按二维码，关注公众号]</p>
      </div>
      <div class="item">
        <p class="other">其他方式</p>
        <p class="desc">打开微信，搜索“太好买”公众号关注即可。</p>
      </div>
      <div class="subscribe-close" onclick="closeSubscribeBox()">
        <i class="iconfont icon-tianjia"></i>
      </div>
    </div>
  @endif
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
    <script>
    wx.config({!! app("wechat.official_account")->jssdk->buildConfig($interfaces ?? [], false) !!});
    wx.ready(function () {
      wx.onMenuShareTimeline({
	title: "{{ $page_title ?? "分享title" }}",
	link: "{{ url()->current() . "?rec=" . auth()->user()->rec_code }}",
	imgUrl: "https://pic1.zhimg.com/v2-c320644d354158004e6fc91d539d0529_im.jpg",
	success: function () {
	  alert("分享成功");
	},
	cancel: function () {
	  alert("取消了");
	}
      });
    });
    function showSubscribeBox (){
      var box = document.querySelector("#subscribe_box");
      box.style.display = "block";
    }
    function closeSubscribeBox (){
      var box = document.querySelector("#subscribe_box");
      box.style.display = "none";
    }
    </script>
    @yield("script")
  </body>
</html>
