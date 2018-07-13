@extends( "layouts.wechat2")

@section( "content")
<div class="container" style="background-color:#fff;">
  @if($type==2)
<div class="payul">
  <div class="pay-way">
    <div class="pay-value">
      <span class="y">付款金额：<i>{{ $order->payment->pay }}</i></span>
    </div>
    <div class="pay-name">
      <span>公司名称：马蜂科技（上海）有限公司</span>
    </div>
    <div class="pay-accout">
      <span>账&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：0382 7500 0400 59723</span>
    </div>
    <div class="accout-name">
      <span>开户银行: 农行江桥支行</span>
    </div>
  </div> <!---->
    <div class="payul-tips">
      <p>太好买需确认收款后才能安排发货。请注意信息提示。有任何疑问请联系您的售后专员。</p>
      <p class="green">{{ $user->admin->name }}：{{ $user->admin->mobile }}</p>
      <p><a href="tel:4009955699">客服电话：400-9955-699</a></p>
    </div>
    <div class="block">
      <a href="{{ route("wechat.order.show" , $order->id) }}" class="to-order">
                    查看订单
          </a>
        </div>
      </div>
      @elseif($type == 3)
      <div class="payul">
        <div class="pay-way">
          <div class="pay-value">
            <span class="y">付款金额：<i>{{ $order->payment->pay }}</i></span>
          </div>
          <div class="pay-name">
            <span>邮寄地址：上海市嘉怡路279弄147号</span>
          </div>
          <div class="pay-accout">
            <span>收件人：王聪</span>
          </div>
          <div class="accout-name">
            <span>电话：13601950978</span>
          </div>
        </div> <!---->
          <div class="payul-tips">
            <p>太好买需确认收款后才能安排发货。请注意信息提示。有任何疑问请联系您的售后专员。</p>
            <p class="green">{{ $user->admin->name }}：{{ $user->admin->mobile }}</p>
	    <p><a href="tel:4009955699">客服电话：400-9955-699</a></p>
          </div>
          <div class="block">
            <a href="{{ route("wechat.order.show" , $order->id) }}" class="to-order">
                          查看订单
                </a>
              </div>
            </div>
            @elseif($type==4)
              <div class="payul">
                <div class="pay-way">
                  <div class="pay-value">
                    <span class="y">付款金额：<i>{{ $order->payment->pay }}</i></span>
                  </div>
                  <div class="pay-name">
                    <span>收到货物后请将回执单</span>
                  </div>
                  <div class="pay-accout">
                    <span>照片发送到公众号。</span>
                  </div>
                  <div class="accout-name">
                    <span>电话：13601950978</span>
                  </div>
                </div> <!---->
                  <div class="payul-tips">
                    <p>收到货物后请及时付款，具体支付方式联系销售专员。</p>
                    <p>有任何疑问请联系您的售后专员。</p>
                    <p class="green">{{ $user->admin->name }}：{{ $user->admin->mobile }}</p>
        	    <p><a href="tel:4009955699">客服电话：400-9955-699</a></p>
                  </div>
                  <div class="block">
                    <a href="{{ route("wechat.order.show" , $order->id) }}" class="to-order">
                                  查看订单
                        </a>
                      </div>
                    </div>
            @endif
    </div>
@endsection
