@extends("layouts.wechat2")

@section("content")
<div class="collect" id="app">
  <div class="header">
    <div class="logo">
      <img src="http://www.taihaomai.com/themes/default/images/logo2.png" />
    </div>
    <div class="title">
      <h2>直接搜货</h2>
    </div>
  </div>
  <div class="container">
    <div class="products" id="product" >
      <div class="product" v-for="(item,index) in items">
        <div class="p-info">
        <a v-bind:href="'{{ route("wechat.product.index") }}/'+item.id">
        <div class="title">
            <span class="p-bname">@{{ item.brand_name }}</span>
            <span class="p-name">@{{ item.name }} </span>
            <span class="p-model">@{{ item.model }}</span>
          </div>
          <div class="pirce">
            <span><i>￥@{{ item.unit_price*1000 }}</i>元/吨</span>
          </div>
          </a>
          </div>
          <div class="p-edit" @click="remove(index)">
            <span>
              <i class="iconfont icon-shoucang y"></i>
              <br />取消
            </span>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
console.log({!! $stars !!})
  new Vue({
    el: '#product',
    data: {
      items: {!! $stars !!}
    },
    methods: {
      remove:function(index){
        console.log(index)
       var data = {
         id : this.items[index].id
       };
        console.log(data)
        axios.post("", data)
        .then(function (res) {
          
        });
        this.items.splice(index, 1);
      }
    }
  })
</script>
@endSection