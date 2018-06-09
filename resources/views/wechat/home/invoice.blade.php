@extends("layouts.wechat2")
<style media="screen">
  .item{
    background-color: #fff;
  }
</style>
@section("content")
  <div class="container">
    <div class="invoice" id="app">
      <div class="item" @click="getAddress">
        选择地址
      </div>
    </div>
  </div>
@endsection
@section("script")
  <script type="text/javascript">
    var app = new Vue({
      el:"#app",
      data:{},
      methods:{
        getAddress:function(){
          console.log(1);
        }
      }
    })

  </script>
@endsection
