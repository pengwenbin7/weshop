@extends("layouts.wechat2")

@section("content")
@if (count($stars))

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
@else
  <div class="no-content">
    <span><i class="iconfont icon-dingdan1"></i></span>

    <br>
    <p><a class="gray" href="{{ route("wechat.product.index") }}">您还没有收藏商品,去看看～</a></p>
     </div>
@endif
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
