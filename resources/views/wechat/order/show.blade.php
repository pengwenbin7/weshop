@extends("layouts.wechat2")

@section("content")
<div class="order-detail" id="app" >
      <div class="container">
        <div class="order-header">
          <div class="order-number">
            <span>订单 {{ $order->no }}</span>
          </div>
          <div class="order-status">
            <span class="y">交易完成</span>
          </div>
        </div>
        <div class="order-address">
          <div class="loc">
            <span><i class="iconfont icon-dizhi"></i></span>
          </div>
          <div class="address-detail">
            <p><span>收货人：{{ $order->address->contact_name }}</span><span class="tel">{{ $order->address->contact_tel }}</span></p>
            <p>{{ $order->address->getText() }}</p>
          </div>
        </div>
        <div class="product-info">
          <div class="p-title">
            <span class = "title">商品信息</span>
            <span class = "express green">查看物流</span>
          </div>
          <div class="product-detail clearfix">
            <div class="item"><span>品名：佰利联</span></div>
            <div class="item"> <span>厂家：佰利联</span></div>
            <div class="item"><span>型号：mmm-21323</span></div>
            <div class="item"><span>数量：13</span></div>
            <div class="item"><span>价格：223</span></div>
          </div>
        </div>
        <div class="contracts">
          <div class="invoice">
            <span><i>发票信息：</i>增值税发票（—）</span><span class="btn-click right">申请开票</span>
          </div>
           <div class="contract">
            <span><i>合同信息：</i>合同已生成</span><span class="btn-click right">生成合同</span>
          </div>
        </div>
        <div class="order-info">
          <div class="order-number">订单编号：1231u289312984718754189</div>
          <div class="order-times">
            <p><span><i>创建时间：</i>2018-01-31 09:21</span></p>
            <p><span><i>付款时间：</i>2018-01-31 09:21</span></p>
            <p><span><i>支付方式：</i>2018-01-31 09:21</span></p>
            <p><span><i>发货时间时间：</i>2018-01-31 09:21</span></p>
            <p><span><i>收货时间：</i>2018-01-31 09:21</span></p>
          </div>
        </div>
        <div class="footer">
          <div class="item price y"><span>实付款：12312837</span></div>
          <div class="item">
            <span class="btn-click">申请售后</span>
          </div>
        </div>
      </div>
      
    </div>
@endsection