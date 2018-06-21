@extends( "layouts.wechat")

@section( "content")
<div class="container" id="app" v-cloak>
  <div class="cart">

    <div class="create" v-on:click="createCart">
      <div class="txt">
        <span class="black">新建选购单<small>(已创建{{ count($carts) }}个选购单)</small></span>
      </div>
      <div class="icon">
        <i class="iconfont icon-tianjia"></i>
      </div>
    </div>
    <div class="cart-list">
      @foreach ($carts as $index => $cartlist)
      <div class="item" ref = "cart_{{ $cartlist->id }}">
        <div class="cart-header">
          <div class="title">
            <a href="{{ route("wechat.cart.show",["id " => $cartlist->id ]) }}">选购单{{ $index+1 }} <small>(已添加{{ count($cartlist->cartItems) }}件商品)</small> </a>
          </div>
          <div class="cart-del" v-on:click="deleteCart({{ $cartlist->id }})">
            <span><i class="iconfont icon-shanchu"></i></span>
          </div>
        </div>
        <div class="cart-addr">
          <a href="{{ route("wechat.cart.show",["id " => $cartlist->id ]) }}">
            <div class="cart-user-info">
              <span>收货人：{{ $cartlist->address->contact_name }}</span>
              <span class="tel">{{ $cartlist->address->contact_tel }}</span>
            </div>
            <div class="cart-desc">
              <p>收货地址: {{ $cartlist->address->province }} {{ $cartlist->address->city }} {{ $cartlist->address->district }}{{ $cartlist->address->detail }}</p>
            </div>
          </a>
        </div>
      </div>
      @endforeach
      @if (!count($carts))
        <div class="no-content">
          <span><i class="iconfont icon-dingdan1"></i></span>

          <br>
          <p><a class="gray" href="{{ route("wechat.product.index") }}">您还没有选购单,点击上面添加按钮新建～</a></p>
           </div>
      @endif
    </div>
  </div>
</div>

@endsection
@section( "script")
<script type="text/javascript">
  var app = new Vue({
    el: "#app",
    data: {

    },
    methods: {
      deleteCart: function(id){
        var _this = this;
        axios.delete("{{ route("wechat.cart.index") }}"+"/"+id)
        .then(function(res){
          if(res.data.delete){
            _this.$refs["cart_"+id].remove();
          }
        })

      },
      createCart: function() {
        console.log(1);
        var $this = this;
        wx.openAddress({
          success: function(res) {
            axios.post( "{{ route("wechat.address.store") }}", res )
            .then(function(res) {
              var url = "{{ route("wechat.cart.store") }}";
              var d = {
                address_id: res.data.address_id
              };
              axios.post(url, d)
              .then(function(res) {
                location.reload();
              });
            });
          },
          cancel: function() {
            //
          }
        });
      }
    }
  })
</script>
@endsection
