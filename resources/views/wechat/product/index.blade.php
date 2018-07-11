@extends( "layouts.wechat")
@section( "content")
<div class="search-box" ref="header" id="header">
  <a href="{{ route("wechat.search") }}">
    <span>快速搜索</span>
    <i class="iconfont icon-sousuo"></i>
  </a>
</div>
<div class="container category clearfix" id="category" v-cloak>
  <div class="cat-nav" ref="left">
    <ul id="cat_nav">
      <li v-for="(item,index) in items" @click="show(item.id)"  :class="active==item.id ? 'item on':'item'">
      <div>
        <span class="c-name">@{{ item.name }}</span>
      </div>
      </li>
    </ul>
  </div>
  <div class="goods-list">
    <div class="products" ref="right" id="products">
      <div class="product" v-for="product in products">
        <a :href="'{{ route("wechat.product.index") }}/'+product.id">
          <div class="prop">
            <p class="p-name">
              <span>@{{ product.name }}</span>
              <span>@{{ product.model }}</span>
            </p>
            <p class="p-bname">
              <span>@{{ product.brand_name }}</span>
              <span class="p-stock">库存:@{{ product.stock }}</span>
            </p>
            <p class="pirce">
              <span class="y" ><i>￥</i>@{{ product.price }}</span>
              <span class="right">@{{ product.address }}</span>
            </p>
          </div>
        </a>
      </div>
      <div class="" v-on:click="more" id="more" v-if="more_box">
        <img src="{{ asset("assets/img/timg.gif") }}" width="25" alt="" style="float:left"> <span>正在加载....</span>
      </div>
    </div>
  </div>
</div>
@endsection
@section( "script")
<script type="text/javascript">
  var app = new Vue({
    el: '#app',
    data: {
      items: {!! $categories !!},
      active: "",
      products: {!! $products !!},
      page: 1,
      total: "",
      id: "",
      more_box: true,
    },
    mounted: function() {
      this.$nextTick(function() {
        this.active = this.items[0].id;
        //获得主体部分高度
        var total = "{{ $pcs }}";
        if (total = 1) {
          this.more_box = false;
        }
        var _height = document.body.clientHeight
        var header = document.querySelector("#header").clientHeight;
        var footer = document.querySelector(".footer").clientHeight;
        this.$refs.left.style.height = _height - header - footer + "px";
        this.$refs.right.style.height = _height - header - footer + "px";
      })

    },
    methods: {
      linkTo: function(url, id) {
        location.assign(url + "/" + id);
      },
      show: function(id) {
        this.id = id;
        this.active = id;
        this.getDate();
      },

      getDate: function(id) {
        var _this = this;
        axios.get("{{ route("wechat.product.index") }}" + "?id=" + _this.id +"page=1")
          .then(function(res) {
            _this.total = res.data.pcs;
            if (_this.total == 1) {
              _this.more_box = false
            } else {
              _this.more_box = true;
            }
            _this.page = 1;
            var domP = document.getElementById("products");
            if(domP){
              domP.scrollTop = 0;  //切换时移动到顶部
            }
            _this.products = res.data.products;
          })
      }
    },
    beforeRouteLeave: function() {

    }
  });
  var me = {}
  var more = document.getElementById("more");
  var element = document.getElementById("products");
  var height, _height, offsetHeight, rHeight;
  rHeight = document.getElementById("header").offsetHeight + 20;
  me.touchmoveCall = function(e) {
    height = element.scrollTop;
    offsetHeight = element.offsetHeight;

    _height = more.offsetTop - rHeight;
    if (_height <= height + offsetHeight) {
      var _this = app;
      if (_this.total > _this.page) {
        _this.page++;
        if (_this.page == _this.total) {
          _this.more_box = false;
        }
      } else {
        _this.more_box = false;
        element.addEventListener("touchmove", me.touchmoveCall)
        return;
      }
      element.removeEventListener('touchmove', me.touchmoveCall);
      axios.get("{{ route("wechat.product.index") }}" + "?id=" + _this.id  + "&page=" + _this.page)
        .then(function(res) {
          var arr = _this.products.concat(res.data.products);
          _this.products = arr;
          element.addEventListener("touchmove", me.touchmoveCall)
        })
    }
  }
  element.addEventListener("touchmove", me.touchmoveCall)
</script>
@endsection
