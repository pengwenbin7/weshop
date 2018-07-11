@extends("layouts.wechat2")

@section("content")
@if (count($stars))
<div class="container collect">
  <div class="list-view">

    <div class="products" >
      @foreach ($stars as  $star)
      <div class="product">
        <div class="p-info">
        <a href="{{ route("wechat.product.show",$star->id) }}">
          <div class="prop">
            <p class="p-name">
              <span>{{ $star->name }}</span>
              <span>{{ $star->model }}</span>
            </p>
            <p class="p-bname">
              <span>{{ $star->brand_name }}</span>
              @if ($star->is_ton)
                <span class="p-stock" >库存:{{ $star->stock }}吨</span>
              @else
                <span class="p-stock" >库存:{{ $star->stock }}{{ $star->packing_unit }}</span>
              @endif
            </p>
            <p class="pirce">
              @if ($star->is_ton)
                <span class="y"><i>￥</i>{{ $star->price }}/吨</span>
              @else
                <span class="y"><i>￥</i>{{ $star->price }}/{{ $star->packing_unit }}</span>
              @endif
            </p>
          </div>
          </a>
          </div>
          <div class="p-edit"  @click="remove('{{route("wechat.unstar",$star->id)}}')">
            <span >
              <i class="iconfont icon-shoucang y"></i>
              <br />取消<br />{{ $star->address }}
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
