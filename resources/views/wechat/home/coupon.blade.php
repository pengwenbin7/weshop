@extends("layouts.wechat2")

@section("content")
<div class="container" id="app">
    <div class="coupon">
        <div class="coupons">
          @foreach($coupons as $coupon)
          <div class="item">
            <div class="c-h">
              <div class="ch-price">
                <span>￥{{ intval($coupon->discount) }}</span>
              </div>
              <div class="ch-info">
                <p class="title">{{  $coupon->description }}</p>
                <p>有效期至：{{  date("Y-m-d", strtotime($coupon->expire) ) }}</p>
              </div>
            </div>
            <div class="c-f">
               <div class="circle"></div>
              <div class="circle-r"></div>
              <div class="cf-desc">
                <p>满{{ intval($coupon->amount) }}元可用</p>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <div class="no-more">
          <span>没有更多的优惠券了</span>
          <hr />
        </div>
      </div>
    </div>
@endsection
