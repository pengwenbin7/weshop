@extends("layouts.wechat2")
<style media="screen">
  .item{
    background-color: #fff;
  }
  .invoice .item{
    line-height: .5rem;
    padding: 0.4rem .4rem;
  }
  .container .btn-bottom{
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    line-height: 1.2rem;
    background-color: #009b45;
    letter-spacing: 3px;
    color: #fff;
    text-align: center;
  }
</style>
@section("content")
  <div class="container" id="app">
    <div class="invoice">
      <div class="item" @click="getAddress">
        <p>收货人：@{{ name }}  @{{ tel }}</p>
        <p>@{{ dist }}</p>
      </div>
    </div>
    <div class="btn-bottom" @click="goInvoice">
      去开票
    </div>
  </div>
@endsection
@section("script")
  <script type="text/javascript">
    var app = new Vue({
      el:"#app",
      data:{
        name: '',
        tel: '',
        dist: ''
      },
      mounted:function(){
        oAddress();
      },
      methods:{
        getAddress:function(){
         oAddress();
       },
       goInvoice:function(){
         alert("去开票")
       }
      }
    })
    function oAddress(){
      wx.openAddress({
        success: function(res) {
  	      var _this = app;
          _this.name = res.userName;
          _this.tel = res.telNumber;
          _this.dist = res.provinceName + res.cityName + res.countryName + res.detailInfo;
          axios.post("{{ route("wechat.address.store") }}", res)
            .then(function(res1) {
            });

        },
        cancel: function() {
          //
        }
      });
    }
  </script>
@endsection
