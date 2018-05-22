@extends( "layouts.wechat2")

@section( "content")
<div class="container">
  <div class="contact" id="app">

    <div class="tel-list">
      @if ($user->admin)
        <div class="private-tel">
          <a href="tel:{{ $user->admin->mobile }}">
            <div class="icon">
              <i class="iconfont icon-zhuanyuan"></i>
            </div>
            <div class="tel-info">
              <p class="title">业务专员</p>
              <p>{{ $user->admin->name }}：<i>{{ $user->admin->mobile }}</i></p>
            </div>
          </a>
        </div>
      @endif

      <div class="public-tel">
        <a href="tel:4009955699">
          <div class="icon">
            <i class="iconfont icon-kefu"></i>
          </div>
          <div class="tel-info">
            <p class="title">客服电话</p>
            <p><i>400-995-5699</i></p>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
