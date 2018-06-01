@extends("layouts.wechat2")

@section("content")

  <div class="container">
<div class="collect" id="app">

    <div class="products" >
      @foreach ($stars as  $star)
      <div class="product">
        <div class="p-info">
        <a href="{{ route("wechat.product.show",$star->id) }}">
        <div class="title">
            <span class="p-bname">{{ $star->brand_name }}</span>
            <span class="p-name">{{ $star->name }} </span>
            <span class="p-model">{{ $star->model }}</span>
          </div>
          <div class="pirce">
            <span><i>￥{{ $star->unit_price*1000 }}</i>元/吨</span>
          </div>
          </a>
          </div>
          <div class="p-edit"  @click="remove('{{route("wechat.unstar",$star->id)}}')">
            <span >
              <i class="iconfont icon-shoucang y"></i>
              <br />取消
            </span>
          </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
@section("script")
<script type="text/javascript">
   new Vue({
     el: "#app",
     data:{},
     methods:{
       remove:function(url){
         console.log(url);
         axios.get(url)
         .then(function(){
           location.reload();
         })
       }
     }
   })
</script>
@endSection
