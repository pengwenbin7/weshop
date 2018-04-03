<!DOCTYPE html>
<html lang="zh-CN">
  <html>
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>{{ $title ?? "weshop" }}</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="{{ asset("bower_components/bootstrap/dist/css/bootstrap.min.css") }}">
      <link rel="stylesheet" href="{{ asset("bower_components/font-awesome/css/font-awesome.min.css") }}">
      @yield("style")
    </head>
    <body>

      @yield("content")

      <script src="{{ asset("/bower_components/jquery/dist/jquery.slim.js") }}"></script>
      <script src="{{ asset("/bower_components/bootstrap/dist/js/bootstrap.js") }}"></script>
      <script src="{{ asset("/bower_components/vue/dist/vue.js") }}"></script>
      <script src="{{ asset("/bower_components/axios/dist/axios.js") }}"></script>
      <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

      <script type="text/javascript" charset="utf-8">
      wx.config({!! app("wechat.official_account")->jssdk->buildConfig($interfaces, true) !!});
      </script>
      @yield("script")
    </body>
