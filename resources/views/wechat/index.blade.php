@extends("layouts.wechat")
@section("content")
<div class="container index">
    <div class="hot-search">
      <div class="link-search">
        <a href="{{ route("wechat.search") }}">
          <div class="text-tips">
            <span>输入关键词快速查找商品</span>
          </div>
          <div class="btn-find">
            <span>找货</span>
          </div>
    	  </a>
      </div>
      <div class="hot-search-items">
        <div class="title">
          <span>热搜</span>
        </div>
        <div class="h-list">
          @foreach ($hot_search as $item)
          <a href="{{ route("wechat.search") }}?keyword={{ $item->keyword }}">{{ $item->keyword }}</a>
          @endforeach
        </div>
      </div>
    </div>
    <div class="list-view">
      <div class="title">
        <span>热卖</span>
      </div>
      <div class="products">
        @foreach($products as $product)
        @if ($product->product->active)
        <div class="product">
          <a href="{{ route("wechat.product.show", $product->product->id) }}">
            <div class="prop">
              <p class="p-name">
                <span>{{ $product->product->name }}</span>
                <span>{{ $product->product->model }}</span>
              </p>
              <p class="p-bname">
                <span>{{ $product->product->brand->name }}</span>
                <span class="p-stock">库存:{{ $product->stock }}</span>
              </p>
              <p class="pirce">
                <span class="y"><i>￥</i>{{ $product->product->price }}</span>
                <span class="right">{{ $product->product->address  }}</span>
              </p>
            </div>
          </a>
        </div>
        @endif
        @endforeach
      </div>

    </div>
</div>
@endsection
@section( "script")
  <script>
wx.ready(function() {
  wx.onMenuShareTimeline({
    title: "正品保障，化工品选购就上太好买！",
    link: "{{ route("wechat.index", [ "rec_code" => auth()->user()->rec_code]) }}",
    imgUrl: "{{ asset("assets/img/logo.png") }}",
    success: function () {
     },
    cancel: function () {
    }
  });

  wx.onMenuShareAppMessage({
    title: "正品保障，化工品选购就上太好买！",
    desc : "我正在使用太好买化工品原料商城购买商品",
    link: "{{ route("wechat.index", ["rec_code" => auth()->user()->rec_code]) }}",
    imgUrl: "{{ asset("assets/img/logo.png") }}",
      success: function () {
          // 用户确认分享后执行的回调函数
      },
      cancel: function () {
          // 用户取消分享后执行的回调函数
      }
  });
});

  </script>
@endsection
