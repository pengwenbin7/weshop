@extends( "layouts.wechat")
@section( "content")
<style media="screen">
  [v-cloak] {
    display: none;
  }
</style>
<div class="container clearfix" id="category">
  <div class="category" id="app">
    <div class="header" ref="header">
      <div class="search">
        <a class="search-box" href="{{ route("wechat.search") }}">
          <i class="iconfont icon-sousuo"></i><span>快速搜索</span>
      </a>
      </div>
    </div>
    <div class="cat-nav" ref="left">
      <ul id="cat_nav">
        <li v-for="(item,index) in items" @click="show(index)"  v-bind:class='{on:active==index}' v-cloak>
        <div :class="index == 0 ? 'item on':'item'">
          <span class="c-name">@{{ item.name }}</span>
        </div>
        </li>

      </ul>
    </div>
    <div class="goods-list">
      <div class="filter clearfix">
        <div class="item"><span>智能推荐</span></div>
        <div class="item">
          <span>按价格</span>
          <span class="uad">
              <i class="iconfont icon-xiangshangshaixuan"></i>
              <i class="iconfont icon-xiangxiashaixuan"></i>
          </span>
        </div>
        <div class="item">
          <span>按销量</span>
          <span class="uad">
              <i class="iconfont icon-xiangshangshaixuan"></i>
              <i class="iconfont icon-xiangxiashaixuan"></i>
          </span>
        </div>
      </div>
      <div class="products" ref="right">
        @foreach ($products as $product)
        <div class="product">
          <a href="{{ route("wechat.product.show", $product->id) }}">
            <div class="prop">
              <p class="black">
                <span class="p-name">{{ $product->name }}</span>
                <span class="p-model">{{ $product->model }}</span>
              </p>
              <p class="gray">
                <span class="p-bname">{{ $product->brand->name }}</span>
              </p>
              <p class="pirce">
                @if($product->is_ton)
                  <span class="y"><i>￥</i>{{ $product->variable->unit_price*1000/$product->content }}/吨</span>
                  @else
                  <span class="y"><i>￥</i>{{ $product->variable->unit_price }}/{{ $product->packing_unit }}</span>
                  @endif
              </p>
            </div>
          </a>
        </div>
        @endforeach


      </div>
    </div>
  </div>
</div>
@endsection
@section( "script")
<script type="text/javascript">
  new Vue({
    el: '#app',
    data: {
      items: {!! $categories !!},
      active: "0"
    },
    mounted: function() {

      //获得主体部分高度
      var _height = document.body.clientHeight
      var fontsize = document.documentElement.clientWidth / 7.5;
      var _h = 33 * (fontsize / 12) - 1;
      var _h2 = 46 * (fontsize / 12) - 2;
      this.$refs.left.style.height = _height - _h + "px";
      this.$refs.right.style.height = _height - _h2 + "px";
    },
    methods: {
      show: function(index) {
        var catName = this.items[index].cateName;
        this.active = index;
        console.log(this.active, index)
        getDate(catName);
      }
    },
    beforeRouteLeave: function() {
      console.log(1)
    }
  })

  function getDate(name) {
    console.log("ajax获取" + name + "的数据")
  }
</script>
@endsection
