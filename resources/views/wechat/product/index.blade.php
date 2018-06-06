@extends( "layouts.wechat")
@section( "content")
<div class="container clearfix" id="category">
  <div class="category" id="app" v-cloak>
    <div class="header" ref="header" id="header">
      <div class="search">
        <a class="search-box" href="{{ route("wechat.search") }}">
          <i class="iconfont icon-sousuo"></i><span>快速搜索</span>
      </a>
      </div>
    </div>
    <div class="cat-nav" ref="left">
      <ul id="cat_nav">
        <li v-for="(item,index) in items" @click="show(item.id)" :class="active==item.id ? 'item on':'item'" v-cloak>
        <div >
          <span class="c-name">@{{ item.name }}</span>
        </div>
        </li>

      </ul>
    </div>
    <div class="goods-list">
      <!-- <div class="filter clearfix" id="fillter">
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
      </div> -->
      <div class="products" ref="right"  id = "products">
        <div class="product" v-for="product in products">
          <a  @click="linkTo('{{ route("wechat.product.index") }}',product.id)">
            <div class="prop">
              <p class="black">
                <span class="p-name">@{{ product.name }}</span>
                <span class="p-model">@{{ product.model }}</span>
              </p>
              <p class="gray">
                <span class="p-bname">@{{ product.name }}</span>
              </p>
              <p class="pirce">
                  <span class="y" v-if="product.is_ton"><i>￥</i>@{{ Number(product.unit_price) }}/吨</span>
                  <span class="y" v-if="!product.is_ton"><i>￥</i>@{{ product.unit_price }}/@{{ product.packing_unit }}</span>
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
      products:{!! $products !!},
      page:1,
      total:"",
      more_box:true,
    },
    mounted: function() {
      this.$nextTick(function () {
        this.active =this.items[0].id;
        //获得主体部分高度
        var total = "{{ $pcs->lastPage() }}";
        console.log(total);
        if(total=1){
          this.more_box=false;
        }
        var _height = document.body.clientHeight
        var fontsize = document.documentElement.clientWidth / 7.5;
        var _h = 33 * (fontsize / 12) - 1;
        var _h2 = 33 * (fontsize / 12) - 1;
        this.$refs.left.style.height = _height - _h + "px";
        this.$refs.right.style.height = _height - _h2 + "px";
      })

    },
    methods: {
      linkTo:function(url,id){
        location.assign(url+"/"+id);
      }
      ,
      show: function(id) {
        var id = id;
        this.active = id;
        this.getDate(id);
      },
      more:function() {
        var id =1;
        var _this =this;
        axios.get("{{ route("wechat.product.index") }}"+"?page=2&&id="+id )
          .then(function(res) {
          var arr = _this.products.concat(res.data.products)
          _this.products=arr;
        })
      },
      getDate: function(id) {
        var _this = this;
        axios.get("{{ route("wechat.product.index") }}"+"?page=1&&id="+id )
          .then(function(res) {
          _this.total=res.data.pcs.last_page;
          if(_this.total==1){
            _this.more_box = false
          }else{
            _this.more_box =true;
          }
          _this.page = 1;
          _this.products = res.data.products;
        })
      }
    },
    beforeRouteLeave: function() {

    }
  });
  var me ={ }
  var more = document.getElementById("more");
  var element = document.getElementById("products");
  var height,_height,offsetHeight,rHeight;
  rHeight = document.getElementById("header").offsetHeight+20;
  me.touchmoveCall=function(e){
    height = element.scrollTop;
    offsetHeight = element.offsetHeight;

    _height = more.offsetTop-rHeight;
    if(_height<=height+offsetHeight ){
      var _this = app;
      if(_this.total>_this.page){
        _this.page++;
        if(_this.page == _this.total){
          _this.more_box = false;
        }
      }else{
        _this.more_box=false;
         element.addEventListener("touchmove",me.touchmoveCall)
        return;
      }
      element.removeEventListener('touchmove', me.touchmoveCall);
      axios.get("{{ route("wechat.product.index") }}"+"?page="+_this.page+"&&id=1")
        .then(function(res) {
        var arr = _this.products.concat(res.data.products);
        _this.products=arr;
        element.addEventListener("touchmove",me.touchmoveCall)
      })
    }
  }
  element.addEventListener("touchmove",me.touchmoveCall)

</script>
@endsection
