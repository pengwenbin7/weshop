@extends("layouts.wechat2")

@section("style")
@endsection
@section("content")

<div class="searchs" id="app">
  <div class="header">
    <div class="search">
      <div class="search-box">
        <form action="{{ route("wechat.search") }}" method="get">
      <input type="text" class="search-inp" name="keyword" id="search_inp" value="" />
          <i class="iconfont icon-sousuo"></i>
          <input class="btn-submit" type="hidden" />
        </form>
    </div>
    </div>
  </div>
  <div class="container">
    <div class="apply-goods">
      <!-- <p>如未找到合适商品，点此可申请所需产品
        <a href="apply_product.html">申请采购</a>
      </p> -->
    </div>
    <div class="products" id="product" >
      @foreach($products as $product)
      <div class="product" v-for="item in items">
        <a href="{{ route("wechat.product.show", $product->id) }}">
        <div class="title">
            <span class="p-bname">{{ $product->brand->name }}</span>
            <span class="p-name">{{ $product->name }} </span>
            <span class="p-model">{{ $product->model }}</span>
          </div>
          <div class="pirce">
            <span><i>￥</i>{{ $product->variable->unit_price*1000 }}元/吨</span>
          </div>
          </a>
      </div>
      @endforeach
    </div>
  </div>

</div>
@endsection
@section("script")
  <script type="text/javascript">
  onload = function(){
    var input = document.getElementById("search_inp");
    input.focus();
  }
  </script>

@endsection
