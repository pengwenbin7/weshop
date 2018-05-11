@extends("layouts.wechat2")

@section("style")
@endsection
<div class="searchs" id="app">
  <div class="header">
    <div class="search">
      <div class="search-box">
      <input type="text" class="search-inp" name="" id="" value="" />
          <i class="iconfont icon-sousuo"></i>
    </div>
    </div>
  </div>
  <div class="container">
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
  <div class="apply-goods">
    <p>如未找到合适商品，点此申请所需产品<a href="apply_product.html">申请采购</a></p>
  </div>
</div>
@section("content")