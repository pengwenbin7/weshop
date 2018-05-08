<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <title>{{ $title ?? "weshop" }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    @yield("style")
  </head>
  <body>
    <nav>
      <a href="{{ route("wechat.index") }}">index</a>
      <a href="{{ route("wechat.product.index") }}">product</a>
      <a href="{{ route("wechat.cart.index") }}">cart</a>
      <a href="{{ route("wechat.home.index") }}">home</a>
      <a href="{{ route("wechat.logout") }}">logout</a>
    </nav>
    @yield("content")
    <div class="footer">
      <div class="item">
        <a href="index.html">
          <span class="icons">
            <i class="iconfont icon-home"></i>
          </span><br>首页</a>
      </div>
      <div class="item">
        <a href="category.html"><span class="icons">
          <i class="iconfont icon-fenlei"></i>
        </span><br>分类</a>
      </div>
      <div class="item on">
        <a href="cart.html"><span class="icons">
          <i class="iconfont icon-caigoudan-on"></i>
        </span><br>采购单</a>
      </div>
      <div class="item">
        <a href="user.html"><span class="icons">
          <i class="iconfont icon-user"></i>
        </span><br><span>我的</span></a>
      </div>
    </div>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
    <script>
    wx.config({!! app("wechat.official_account")->jssdk->buildConfig($interfaces ?? [], true) !!});
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
    </script>
    @yield("script")
  </body>
</html>
