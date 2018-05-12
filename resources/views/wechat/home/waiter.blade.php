@extends("layouts.wechat2")

@section("content")
<div class="contact" id="app">
  <div class="container">
    <div class="tel-list">
      <div class="private-tel">
        <a href="tel:{{ $user->admin->mobile }}">
          <div class="icon">
            <i class="iconfont icon-zhuanyuan"></i>
          </div>
          <div class="tel-info">
            <p class="title">业务专员</p>
            <p>{{ $user->admin->name }}：<i class="purple">{{ $user->admin->mobile }}</i></p>
          </div>
        </a>
      </div>
      <div class="public-tel">
        <a href="tel:4009955699">
          <div class="icon">
            <i class="iconfont icon-kefu"></i>
          </div>
          <div class="tel-info">
            <p class="title">客服电话</p>
            <p><i class="a">400-995-5699</i></p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
