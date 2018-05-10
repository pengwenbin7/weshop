@extends("layouts.admin")

@section("content")
  {!! $target !!}
@endsection

@section("script")
  <script src="http://rescdn.qqmail.com/node/ww/wwopenmng/js/sso/wwLogin-1.0.0.js"></script>

  <script>
  wx.config('{!! $config !!}');
  window.WwLogin({
    "id" : "wx_reg",
    "appid" : "",
    "agentid" : "",
    "redirect_uri" :"",
    "state" : "",
    "href" : "",
  });
  wx.ready(function() {
    wx.checkJsApi({
      jsApiList: ['scanQRCode'], // 需要检测的JS接口列表，所有JS接口列表见附录2,
      success: function(res) {
	location.assign('{!! $target !!}');
      },
    });
  });
  </script>
@endsection
