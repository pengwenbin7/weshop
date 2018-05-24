<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title>{{ $title ?? "Admin" }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset("assets/css/app.css") }}" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/skins/skin-blue.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/select2/4.0.6-rc.1/css/select2.min.css" rel="stylesheet">
    <style>
    input:required, select:required, textarea:required {
      border-color: #EE7777;
    }
    </style>
    @yield("style")
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      @include("layouts.common.header")
      @include("layouts.common.sidebar")
      <div class="content-wrapper" id="app">
	<!-- Main content -->
	<section class="content container-fluid">
	  @yield('content')
	</section>
      </div>

      @include("layouts.common.footer")
    </div>

    <script src="{{ asset("assets/js/app.js") }}"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/admin-lte/2.4.3/js/adminlte.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/select2.min.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.6-rc.1/js/i18n/zh-CN.js"></script>
    
    <script>
    $(document).ready(function () {
      $(".select2").select2({
	language: "zh-CN"
      });
    });
    </script>
    @yield("script")
  </body>
</html>
