<!doctype html>
<html lang="zh-CN">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>支付１分</title>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall()
    {
      WeixinJSBridge.invoke(
	"getBrandWCPayRequest",
	{!! $json !!},
	function (res) {
	  WeixinJSBridge.log(res.err_msg);
	}
      );
    }

    function callpay()
    {
      if (typeof WeixinJSBridge == "undefined") {
	if ( document.addEventListener ) {
	  document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	} else if (document.attachEvent) {
	  document.attachEvent('WeixinJSBridgeReady', jsApiCall);
	  document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	}
      } else {
	jsApiCall();
      }
    }
    </script>
  </head>
  <body>
    <button onclick="callpay()">点击支付1分</button>
  </body>
    <script type="text/javascript">
    wx.config({!! app("wechat.official_account")->jssdk->buildConfig(["onMenuShareTimeline", "onMenuShareAppMessage"], false) !!});
    </script>
  </body>
</html>
