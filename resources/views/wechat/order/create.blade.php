@extends("layouts.wechat2")

@section("content")
<div class="order" id="app">
			<div class="container">
				<div class="address">
					<div class="a-info">
					<p class="green" v-on:click="selectAddress">请选择收货地址</p>
						<!-- <div class="name">
							<span class="user-name">王先生</span>
							<span>18949100000</span>
						</div>
						<div class="a-dist">
							<p>上海市嘉定区江桥镇嘉怡路279弄147号999</p>
						</div> -->
					</div>
					<div class="right-arrow">
						<i class="iconfont icon-jinru"></i>
					</div>
				</div>
				<div class="products">
				@foreach ($products as $product)
					<div class="product">
						<div class="p-info">
							<div class="title">
								<span class="p-bname">  {{ $product->brand->name }}</span>
								<span class="p-name"> {{ $product->name }} </span>
								<span class="p-model"> {{ $product->model }} </span>
							</div>
							<div class="num clearfix">
								<span>数量：<i class="black">@{{ number }}包</i><i class="black">25KG</i></span>

							</div>
							<div class="pirce">
								<span>价格：<i class="black">￥{{ $product->variable->unit_price*25 }}</i></span>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			 <div class="grid">
				 <div class="item" @click="show('curpon')">
					 <span> 优惠券</span>
					 <span class="value y">-￥300 <i class="iconfont icon-zhankai"></i></span>
				 </div>
				 <div class="item">
					 <span> 实付款</span>
					 <span class="value">￥300</span>
				 </div>
				 <div class="item" @click="show('paymode')">
					 <span> 支付方式</span>
					 <span class="value"><i class="iconfont icon-weixinzhifu"></i>微信支付<i class="iconfont icon-zhankai"></i></span>
				 </div>
			 </div>
			</div>
			<div class="footer order-footer">
				<div class="item"  v-on:click="pay">
					<span>提交订单</span>
				</div>
			</div>

			<div class="flexbox" v-if="paymode">
				<div class="mask" @click="hideBox()"></div>
				<div class="paymode">
					<div class="tit">选择支付方式</div>
					<div class="pay-list">
						<div class="item">
							<span>微信支付</span>
							<span class="icon"><i class="iconfont icon-weixinzhifu"></i></span>
						</div>
						 <div class="item">
							<span>线下付款</span>
							<span class="icon"><i class="iconfont icon-xianxiazhifu"></i></span>
						</div>
						 <div class="item">
							<span>银行汇票</span>
							<span class="icon"><i class="iconfont icon-huipiao"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="flexbox" v-if="curpon">
				<div class="mask" @click="hideBox()"></div>
				<div class="coupon-list">
					<div class="tit">优惠券<small>(1张可用)</small></div>
					<div class="coupons">
						<div class="item">
							<div class="c-h">
								<div class="ch-price">
									<span>￥200</span>
								</div>
								<div class="ch-info">
									<p class="title">新人专属红包礼券</p>
									<p>有效期至：2018-05-01</p>
								</div>
							</div>
							<div class="c-f">
								 <div class="circle"></div>
								<div class="circle-r"></div>
								<div class="cf-desc">
									<p>满10000元可用</p>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="c-h">
								<div class="ch-price">
									<span>￥200</span>
								</div>
								<div class="ch-info">
									<p class="title">新人专属红包礼券</p>
									<p>有效期至：2018-05-01</p>
								</div>
							</div>
							<div class="c-f">
								<div class="circle"></div>
								<div class="circle-r"></div>
								<div class="cf-desc">
									<p>满10000元可用</p>
								</div>
							</div>
						</div>
					</div>
					<div class="no-use" @click="hideBox()">
						<span>不使用优惠券</span>
					</div>
				</div>
			</div>
		</div>
	<!-- <div id="app">
		<p>
			 <p>
	addr_id: <input type="number" v-model="address_id">
	<button v-on:click="selectAddress">select address</button>
			</p>
			付款方式：
			<select v-model="channel_id">
	@foreach ($payChannels as $channel)
		<option value="{{ $channel->id }}">
			{{ $channel->name }}
		</option>
	@endforeach
			</select>
			<div v-if="address_id">
	<button v-on:click="pay">pay</button>
			</div>
			<div v-else>
	<button disabled>pay</button>
			</div>
	</div> -->
@endsection

@section("script")
	<script>
	var app = new Vue({
		el: "#app",
		data: {
			is_ton: {{ $product->is_ton }},
			show_number: 1,
			address_id: 1,
			channel_id: 1,
			freight: 0,
			paymode:false,
			curpon:false
		},
		computed: {
			number: function () {
				return 0 == this.is_ton?
				this.show_number:
				this.show_number * 1000 / {{ $product->content }};
			}
		},
		beforeCreate: function () {

			 if(!this.address_id){
				 //选择地址
				 console.log(this.address_id);
				 wx.openAddress({
					 success: function (res) {
						 axios.post("{{ route("wechat.address.store") }}", res)
						 .then(function (res) {
							 var url = "{{ route("wechat.cart.store") }}";
							 var d = {
					 address_id: res.data.address_id
							 };
							 axios.post(url, d).
					 then(function (res) {
						 location.reload();
					 });
						 });
					 },
					 cancel: function () {
						 //
					 }
				 });
			 }
		},
		methods: {
			show:function(mode){
						if(mode == 'paymode'){
							this.paymode = true;
						}else{
							this.curpon = true
						}
					},
					hideBox:function(){
						this.paymode=false;
						this.curpon = false;
					},
			// storage default freight function
			storageFunc: function () {
	var func = JSON.parse('{!! $product->storage->func !!}');
			},

			selectAddress: function () {
	var $this = this;
	wx.openAddress({
		success: function (res) {
			axios.post(
				"{{ route("wechat.address.store") }}",
				res
			).then(function (res) {
				$this.address_id = res.data.address_id;
			});
		},
		cancel: function () {
			alert("取消");
		}
	});
			},

			pay: function () {
	var data = {
		address_id: this.address_id,
		channel_id: this.channel_id,
		products: [
			{
				number: this.number,
				id: {{ $product->id }}
			}
		]
	};
	axios.post("{{ route("wechat.order.store") }}", data)
		.then(function (res) {
			location.assign("{{ route("wechat.pay") }}" +
				"/?order_id=" + res.data.store);
		});
			},

			countFreight: function () {
	var $this = this;
	var data = {
		address_id: this.address_id,
		products: [
			{id: {{ $product->id }}, number: $this.number}
		]
	};
	axios.post("{{ route("wechat.order.count-freight") }}",
		data).then(function (res) {
			$this.freight = res.data;
		});
			}
		},

		mounted: function () {
		}

	});
	</script>
@endsection
