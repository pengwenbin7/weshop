@extends("layouts.wechat")

@section("content")
<div class="cart">

      <div class="container" id="app">
        <div class="create">
          <div class="txt">
            <span class="black">新建选购单<small>(已创建1个采购单)</small></span>
          </div>
          <div class="icon">
            <i class="iconfont icon-tianjia"></i>
          </div>
        </div>
        <div class="cart-list">
        @foreach ($carts as $cartlist)
          <div class="item">
            <div class="cart-header">
              <div class="title">
                <a href="{{ route("wechat.cart.show",["id" => $cartlist->id ]) }}">采购单1 <small>(已添加2件商品)</small> </a>
              </div>
               <div class="cart-del">
                <span><i class="iconfont icon-del"></i></span>
              </div>
            </div>
            <div class="cart-addr">
              <a href="{{ route("wechat.cart.show",["id" => $cartlist->id ]) }}">
              <div class="cart-user-info">
                <span>收货人：{{ $cartlist->address->contact_name }}</span>
                <span class="tel">{{ $cartlist->address->contact_tel }}</span>
              </div>
              <div class="cart-desc">
                <p>收货地址: {{ $cartlist->address->province }}
                {{ $cartlist->address->city }}
                {{ $cartlist->address->district }}{{ $cartlist->address->detail }}</p>
              </div>
              </a>
            </div>
          </div>
        @endforeach
        </div>
      </div>
  
@endsection
