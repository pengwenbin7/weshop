<!doctype html>
<html lang="zh-CN">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>收银台</title>
    <link rel="stylesheet" href ="{{asset("assets/css/reset.css")}}" >
    <link rel="stylesheet" href =" {{asset("assets/font/iconfont.css")}}">
    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
    <style media="screen">
    [v-cloak] {
      display: none;
    }
    html,body{padding:0;margin:0;font-size:50px;}
    body{position: relative;}
    .pay{font-size:.32rem;margin-top:.4rem;}
    .pay .item{width: 100%; background-color: #fff;height: 1.6rem;padding: .3rem .4rem;}
    .pay .item .pay-t{width: 100%;line-height: .5rem;}
    .pay .item .pay-t i{font-size: .4rem;font-weight: bold;}
    .pay .item .pay-limit{width: 100%; line-height: .4rem;font-size: .28rem;color: #888;}
    .group{margin-top: .4rem;}
    .group .item {display: flex;display: -webkit-flex;height: 1.3rem;padding: .25rem .4rem;line-height: .8rem;border-bottom: 1px solid #eee;}
    .group .item .icon{ width: .7rem; font-size: .5rem;text-align: center;}
    .group .item .pay-title{flex: 1;-webkit-flex:1;line-height: .8rem;}
    .group .item .pay-title p.gray{font-size: .28rem; color: #888;}
    .group .item .pay-title p.title{font-size: .32rem;font-weight: bold;}
    .footer{width:100%; position: absolute;bottom: 0;height: 1.2rem;line-height: 1.2rem;background-color: #00b945;}
    .footer span{display: block;width: 100%;text-align: center;font-weight: bold;color: #fff;letter-spacing: 2px;font-size: .34rem;}
    .footer span a{color: #fff;}
    .icon-duigongzhuanzhang{color: #3bb6ff;}
    .icon-huipiao{color: #c273ff;}
    .icon-xuanzhong-on{color: #3db858;}
    .icon-huodaofukuan{color: #16c2c2;}
    .paydis{position: absolute; right: 0;top: .2rem;width: 2.8rem;padding: .2rem; background-color: #f30;border-radius: 3px;}
    .paydis i{display: block;height: .2rem;width: 4px; background-color: #f00; position: absolute;right: .4rem;top: -0.2rem;}
    .paydis span{display: block;padding: .2rem;line-height:.3rem;  border: 1px dotted #fff; font-size: 12px; color: #fff;}
    .share{position: fixed;bottom: 1.4rem; right: .5rem; width: 4rem;background-color: #666;border-radius: 100px;height: .8rem;font-size: .3rem;padding: .2rem;box-sizing: border-box;}
    .share .close{width: .5rem;float: left;height: .4rem;line-height: .4rem;font-size: .5rem;color: #fff;border-right: 1px solid #fff;}
    .share .close span{display: block; line-height: .4rem; }
    .share .s-info{margin-left: .5rem; text-align: center;color: #fff;line-height: .4rem;}

    </style>
    <script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall()
    {
      WeixinJSBridge.invoke(
	"getBrandWCPayRequest",
	{!! $json !!},
	function(res){
	  WeixinJSBridge.log(res.err_msg);
	  alert(res.err_code+res.err_desc+res.err_msg);
	}
      );
    }

    function callpay()
    {
      if (typeof WeixinJSBridge == "undefined"){
	if( document.addEventListener ){
	  document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
	}else if (document.attachEvent){
	  document.attachEvent('WeixinJSBridgeReady', jsApiCall);
	  document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
	}
      }else{
	jsApiCall();
      }
    }
    </script>
  </head>
  <body style="background-color:#f0f1f0;">

    <div class="container" id="app" v-cloak>
      <div class="paydis" v-show="share&&out_time">
        <i></i>
        @if ($order->payment->share_discount <= 0)
  	<span>点击分享订单，立减{{  intval($order->payment->pay * App\Models\Config::get("order.share.discount")) }}元</span>
        @else
  	<span>分享已减{{ intval($order->payment->share_discount) }}元</span>
        @endif
      </div>
      <div class="pay">
	<div class="item">
	  <div class="pay-t">
            <span>需支付：<i class="y">￥{{ $order->payment->pay  }}</i></span>
	  </div>
	  <div class="pay-limit">
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余支付时间：@{{ expire }}</p>
	  </div>
	</div>
	<div class="group">
	  <div v-for="item in items">
            <div class="item" v-on:click="setChannel(item.id)" v-bind:class="item.id==active?'on':''" >

              <div class="icon">
            		<i class="iconfont icon-weixinzhifu" v-if="item.id==1"></i>
            		<i class="iconfont icon-duigongzhuanzhang" v-if="item.id==2"></i>
            		<i class="iconfont icon-huipiao" v-if="item.id==3"></i>
            		<i class="iconfont icon-huodaofukuan" v-if="item.id==4"></i>
              </div>
              <div class="pay-title" >
		<p class="title">@{{ item.name }}</p>
              </div>

              <div class="icon">
		<i v-bind:class="active==item.id?'iconfont icon-xuanzhong-on':'iconfont icon-xuanzhong' "></i>
              </div>
            </div>

	  </div>
	</div>
      </div>
      <div class="share"  v-show="share&&out_time">
        <div class="close" @click="share=false">
          <span>×</span>
        </div>
        <div class="s-info">
           <span>分享订单获得减免</span>
        </div>
      </div>
      <div class="footer" v-if="out_time">
	<span v-if="active==1"  onclick="callpay()">确认支付</span>
	<span v-if="active==2">
	  <a href="{{ route("wechat.pay.offline", ["order_id" => $order->id, "type" => 2, "channel_id" => 2]) }}">
	    确定
	  </a>
	</span>
	<span v-if="active==3">
	  <a href="{{ route("wechat.pay.offline", ["order_id" => $order->id, "type" => 3, "channel_id" => 3]) }}">
	    确定
	  </a>
	</span>
	<span v-if="active==4">
	  <a href="{{ route("wechat.pay.offline", ["order_id" => $order->id, "type" => 4, "channel_id" => 4]) }}">
	    确定
	  </a>
	</span>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript">
    wx.config({!! app("wechat.official_account")->jssdk->buildConfig(["onMenuShareTimeline"], false) !!});
    var app = new Vue({
      el: '#app',
      data: {
        items: {!! $pay_channel !!},
        active: 1,
        expire:"",
        out_time:false,
        share:true,
      },
      mounted () {
        countdown(this)
      },
      methods: {
        setChannel:function(index){
          this.active = index;
        }
      }

    })
      function countdown(_this){
	var order_expire ={{ strtotime($order->expire) }} ;
	var expire = 0;
	time = setInterval(function () {
          timestamp =parseInt(new Date().getTime()/1000);
          expire = order_expire - timestamp;
          _this.expire = init(expire);
	}, 1000);
      }
    function init(mss){
      if(mss<=1){
        clearInterval(time);
        //订单超时
        app.out_time=false;
        return "订单超时";

      }else{
        app.out_time=true;
      }
      var days = parseInt(mss / (60 * 60 * 24))?parseInt(mss / (60 * 60 * 24))+"天 ":"";
      var hours = parseInt((mss % ( 60 * 60 * 24)) / (60 * 60))?parseInt((mss % ( 60 * 60 * 24)) / (60 * 60))+"时 ":"";
      var minutes = parseInt((mss % (60 * 60)) / 60);
      var seconds = mss % 60;
      return days + hours + minutes + "分 " + seconds + "秒 ";
    }
    wx.ready(function () {
      wx.onMenuShareTimeline({
	title: "分享title",
	link: "{{ route("wechat.index", ["rec" => auth()->user()->rec_code]) }}",
	imgUrl: "https://pic1.zhimg.com/v2-c320644d354158004e6fc91d539d0529_im.jpg",
	success: function () {
          axios.post("{{ route("wechat.order.share", $order) }}")
	    .then(function (res) {
	      location.reload();
	    });
	},
	cancel: function () {
          alert("取消了");
	}
      });
    });
    </script>
  </body>
</html>
