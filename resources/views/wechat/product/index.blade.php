@extends("layouts.wechat")
@section("content")
<div class="category" id="app">
  <div class="header" ref = "header">
    <div class="title">
      <h2>分类找货</h2>
    </div>
    <div class="search">
      <a class="search-box" href="{{ route("wechat.index") }}">
          <i class="iconfont icon-sousuo"></i><span>快速搜索</span>
      </a>
    </div>
  </div>
  <div class="container clearfix">
    <div class="cat-nav" ref = "left">
      <ul id="cat_nav">
      @foreach ($categories as $category)
      <li  >
          <div class="on">
            <span class="sign">&nbsp;</span><span class="c-name">{{ $category->name }}</span>
          </div>
        </li>
      @endforeach
        
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
      <div class="products"  ref="right">
      @foreach ($products as $product)
        <div class="product">
          <a href="{{ route("wechat.product.show", $product->id) }}">
          <div class="title">
            <span class="p-bname">{{ $product->storage->name }}</span>
            <span class="p-name">{{ $product->name }} </span>
            <span class="p-model">{{ $product->model }} </span>
          </div>
          <div class="pirce">
            <span><i class="y">￥
            @if ($product->is_ton)
            {{ $product->variable->unit_price * 1000 / $product->content }}
            @else
            {{ $product->variable->unit_price }}
            @endif
           </i></span>
          </div>
          </a>
        </div>
        @endforeach
       
        
      </div>
    </div>
  </div>
  <div class="footer" ref = "footer">
    <div class="item">
      <a href="index.html">
        <span class="icons">
          <i class="iconfont icon-home"></i>
        </span><br>首页</a>
    </div>
    <div class="item on">
      <a href="category.html"><span class="icons">
          <i class="iconfont icon-fenlei-on"></i>
        </span><br>分类</a>
    </div>
    <div class="item">
      <a href="cart.html"><span class="icons">
          <i class="iconfont icon-caigoudan"></i>
        </span><br>采购单</a>
    </div>
    <div class="item">
      <a href="user.html"><span class="icons">
          <i class="iconfont icon-user"></i>
        </span><br><span>我的</span></a>
    </div>
  </div>
</div>
  
@endsection
@section("script")
   <script type="text/javascript">
      new Vue({
        el: '#app',
        data: {
          items: [{
              cateName: '涂料乳液'
            },
            {
              cateName: '油性树脂'
            },
            {
              cateName: '水性树脂'
            },
            {
              cateName: '颜料类'
            },
            {
              cateName: '填料类'
            },
            {
              cateName: '油性助剂'
            }, {
              cateName: '水性助剂'
            }, {
              cateName: '通用塑料'
            }, {
              cateName: '工程塑料'
            }, {
              cateName: '热塑弹性体'
            }, {
              cateName: '塑料助剂'
            }, {
              cateName: '聚酯树脂'
            }
          ],
          active: "0"
        },
        mounted:function(){

          //获得主体部分高度
          var _height =  document.body.clientHeight 
          var fontsize = document.documentElement.clientWidth / 7.5;
          var _h = 30*(fontsize/12)+1;
          var _h2 = 45*(fontsize/12)+1;
          this.$refs.left.style.height = _height-_h+"px";
          this.$refs.right.style.height = _height-_h2+"px";
        }
        ,
        methods: {
          // show: function(index) {
          //   var catName = this.items[index].cateName;
          //   this.active = index;
          //   console.log(this.active, index)
          //   getDate(catName);
          // }
        },
        beforeRouteLeave:function(){
          console.log(1)
        }
      })

      function getDate(name) {
        console.log("ajax获取" + name + "的数据")
      }
    </script>
    @endsection