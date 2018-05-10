@extends("layouts.wechat")

@section("content")
<div class="user">
	    <!--<div class="header">
	      <div class="title">
	        <h2>用户中心</h2>
	      </div>
	      <div class="u-photo">
	        <div class="photo">
	          <img src="imgs/u_photo.png"/>
	        </div>
	        <div class="name">
	          <span>王小妹</span>
	        </div>
	        <div class="admin-msg">
	          <span class="icons">
	            <i class="iconfont icon-xiaoxitixing"></i>
	          </span>
	        </div>
	      </div>
	    </div>-->
	    <div class="container">
	      <div class="grid">
	        <div class="item ord">
	          <a href="{{ route("wechat.order.index") }}">
	          <div class="icon">
	            <i class="iconfont icon-dingdan"></i>
	          </div>
	          <div class="txt"><span>全部订单</span></div>
	         
	          </a>
	        </div>
	       <div class="item">
            <a href="##">
            <div class="icon">
              <i class="iconfont icon-fapiao"></i>
            </div>
            <div class="txt"><span>申请开票</span></div>
           
            </a>
          </div>
          <div class="item">
            <a href="coupon.html">
            <div class="icon">
              <i class="iconfont icon-youhuiquan"></i>
            </div>
            <div class="txt"><span>优惠券</span></div>
           
            </a>
          </div>
          <div class="item">
            <a href="##">
            <div class="icon">
              <i class="iconfont icon-tuihuanhuo"></i>
            </div>
            <div class="txt"><span>退换货</span></div>
            
            </a>
          </div>
          
	      </div>
	      <div class="grid">
          <div class="item">
            <a href="collect.html">
            <div class="icon">
              <i class="iconfont icon-wodeshoucang"></i>
            </div>
            <div class="txt"><span>我的收藏</span></div>
            <!--<div class="icon">
              <i class="iconfont icon-jinru"></i>
            </div>-->
            </a>
          </div>
           <div class="item">
            <a href="contact.html">
            <div class="icon">
              <i class="iconfont icon-kefu"></i>
            </div>
            <div class="txt"><span>联系客服</span></div>
            </a>
          </div>
        </div>
        
	    </div>
	    
	  </div>
@endsection
