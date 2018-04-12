<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <title>{{ $title ?? "weshop" }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/ionic/1.3.2/css/ionic.min.css" rel="stylesheet">
    @yield("style")
  </head>
  <body>
    <nav>
      <a href="{{ route("wechat.index") }}">index</a>
      <a href="{{ route("wechat.product.index") }}">product</a>
      <a href="{{ route("wechat.cart.index") }}">cart</a>
      <a href="{{ route("wechat.home.index") }}">home</a>
    </nav>
    @yield("content")
    
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
    <script type="text/javascript" charset="utf-8">
    wx.config({!! app("wechat.official_account")->jssdk->buildConfig($interfaces ?? [], true) !!});
    </script>
    @yield("script")
  </body>
</html>
