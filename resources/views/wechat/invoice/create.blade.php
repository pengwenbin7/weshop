@extends("layouts.wechat2")

@section("style")
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
@endsection

@section("content")
  <div class="container" id="app">
    <div class="invoice">
      <div class="item" @click="getAddress">
        <p>收票地址：@{{ name }}  @{{ tel }}</p>
        <p>@{{ dist }}</p>
      </div>
    </div>
    <div v-if="address_id" class="btn-bottom" @click="goInvoice">
      去开票
    </div>
  </div>
@endsection
@section("script")
  <script type="text/javascript">
  var app = new Vue({
    el: "#app",
    data: {
      name: '',
      tel: '',
      dist: '',
      address_id: null
    },
    mounted: function() {
    },
    methods: {
      getAddress: function() {
	var _this = this;
	wx.openAddress({
	  success: function(res) {
            _this.name = res.userName;
            _this.tel = res.telNumber;
            _this.dist = res.provinceName + res.cityName + res.countryName + res.detailInfo;
            axios.post("{{ route("wechat.address.store") }}", res)
              .then(function(res1) {
		_this.address_id = res1.data.address_id;		
              });
	  }
	});
      },

      goInvoice: function() {
	var data = {
	  address_id: this.address_id,
	  order_id: {{ $order_id }}
	};
	axios.post("{{ route("wechat.invoice.store") }}", data)
	  .then(function (res) {
	    location.assign("http://jskp.jss.com.cn/k.action?kpdm=A7K23M");
	  });
      }
    }
  });

  wx.ready(function () {
    app.getAddress();
  });
  </script>
@endsection
