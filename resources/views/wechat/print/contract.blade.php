<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8"/>
    <title>{$order.order_sn}</title>
    <style>
    body {
      font-family: msyh;
      font-size: 14px;
    }

    @page {
    margin: 140px 62px 60px;
    padding: 0;
    header: pdfHeader;
    footer: pdfFooter;
    }
    table th{font-weight: normal;}
    main{padding-top: 10px; width: 670px;color: #000;}
    main table{width: 670px;}
    h4{text-align: left; width: 100%;line-height: 120%;padding: 0;margin: 0;font-size: 16px;}
    h1{text-align: center; width: 100%;line-height: 120%;font-size: 20px;font-weight: bold;}
    .txt{width: 670px;word-break: break-all;line-height: 50px;}
    .seal {

    }
    </style>
  </head>
  <body>
    <htmlpageheader name="pdfHeader" style="display:none">
      <div style="border-bottom:1px solid #222;">
	<table align="left" style="" width="670px" height="110">
	  <tr style="color:#000;" >
	    <td rowspan="5" width="100px"  align="center">
              <img  src="images/mf-logo.png" style="width:53px;"/>
	    </td>
	    <td colspan="3"><h4>马蜂科技（上海）有限公司</h4></td>
	  </tr>
	  <tr style="font-size:11px;line-height: 12px;color:#222;">
	    <td colspan="3">上海市嘉定区江桥镇嘉怡路279弄147号</td>
	  </tr>
	  <tr style="font-size:11px;line-height: 12px;color:#222;">
	    <td colspan="3">客服电话:400-9955-699 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEL:021-69000038&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FAX：021-6900 0037</td>
	  </tr>
	  <tr style="font-size:11px;line-height: 12px;color:#222;">
	    <td colspan="3">E-mail：leo@taihaomai.com&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;http://www.taihaomai.com</td>
	  </tr>
	</table>
      </div>
    </htmlpageheader>
    <htmlpagefooter name="pdfFooter" style="display:none; background-color: red;">
      <div style="text-align: center; border-top:1px solid #222; padding-top: 20px; " >第{PAGENO}页，共{nb}页</div>
    </htmlpagefooter>

    <div class="main">
      <h1><b>化工品购销合同</b></h1>

      <table style="width: 670px; " align="center">
	<tr >
	  <td colspan="2"></td>
	</tr>
	<tr style="line-height: 15px;">
	  <td style="text-align: left;  ">需方：{if $company}{$company.company_name}{else}个人{/if}</td>
	  <td style="text-align: right; ">合同编号：M{$order.order_sn}</td>
	</tr>
	<tr style="line-height: 15px;">
	  <td style="text-align: left; ">供方：马蜂科技（上海）有限公司</td>
	  <td style="text-align: right; ">签订日期：{$order.pay_time}</td>
	</tr>
	<tr>
	  <td colspan="2">

	  </td>
	</tr>
      </table>
      <table align="center" border="1" cellpadding="0" cellspacing="0" width="670" style="width: 670px;  text-align: center;">
	<tr style="height: 200%;">
	  <th style="height: 30px;">货号</th>
	  <th>商品名称及型号</th>
	  <th>生产厂商</th>
	  <th>单价(元/包)</th>
	  <th width="100">数量(包)</th>
	  <th>合计</th>
	</tr>
	{foreach from=$goods_list item=goods}
	<tr style="height: 200%;">
	  <td style="height: 30px;"><span class="red">{$goods.goods_sn}</span></td>
	  <td><span class="red">{$goods.model}{$goods.goods_name}</span></td>
	  <td><span class="red">{$brand_list[$goods.brand_id]}</span></td>
	  <td><span class="red">{$goods.goods_price}</span></td>
	  <td><span class="red">{$goods.goods_number}</span></td>
	  <td><span class="red">{$goods.subtotal}</span></td>
	</tr>
	{/foreach}
	<tr>
	  <td colspan="2"   style="height: 30px;">合计金额（大写）</td>
	  <td colspan="3" style="text-align: left;padding-left: 20px;">{$order.china_amount}</td>
	  <td >￥{$order.order_amount}</td>
	</tr>
      </table>
      <table style="width: 670px; " align="center">
	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;padding-top: 20px;">
	    <div class="txt">一、质量约定：所有产品质量均以厂家出厂质量检测标准或国家规定标准为准，需方收到货物后检验合格则<br />收货，如检验后该产品不符合需方要求，供方无条件负责退换货及退还需方为本合同所付款项。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">二、运输方式及费用负担：供方承担。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">三、包装规格：依据工厂出厂标准。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">四、结算方式及期限：<span class="red">款到发货</span>（报价为含税到厂价）。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">五、解决纠纷的方式：供需双方如果发生争议，应当友好解决。协商不成，应将争议提交供方所在法院诉<br />讼解决。</div>
	    <div style="text-indent: 34px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(1)败方需承担与诉讼有关的一切实际发生的费用（包括但不限于律师费、调查费、差旅费等费用）。</div>
	    <div style="text-indent: 34px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(2)需方没有按时付款的，则每逾期一天，应向供方支付应付款额的千分之三作为违约金。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">六、交货时间：依据平台交货周期，或按双方商定。具体联系销售代表。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    七、其他约定：<br />
	    <div style="text-indent: 34px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(1) 本合同一式两份，供需双方各执一份，条款内容修改无效。  </div>
	    <div style="text-indent: 34px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(2) 本合同一经双方签字盖章后即生效，合同传真件与原件均具同等法律效应。</div>
	    <div style="text-indent: 24px; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(3) 本合同未尽事宜，则由双方协商解决。</div>
	  </td>
	</tr>

	<tr style="line-height:120%; ">
	  <td colspan="2" style="text-align: left;">
	    <div class="txt">八、“太好买”电商平台为马蜂科技（上海）有限公司旗下化工品B2B交易平台，客户在平台或线下交易，<br />供方均为马蜂科技。</div>
	  </td>
	</tr>
      </table>

      <div style="page-break-inside: avoid;">
	<table style="width: 670px; " align="center">
	  <tr style="line-height: 10px;">
	    <td  colspan="2">&nbsp;&nbsp;</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">供货单位名称：马蜂科技（上海）有限公司</td>
	    <td style="width:50%;text-align: left;">需方单位名称：{if $company}{$company.company_name}{else}个人{/if}</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">联系地址：上海江桥嘉怡路279弄147号</td>
	    <td style="width:50%;text-align: left;">地址：{$order.user_address}</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">电 话：021-69000038</td>
	    <td style="width:50%;text-align: left;">手机号：{$order.mobile}</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;"> 传 真：021-69000037</td>
	    <td style="width:50%;text-align: left;"> 传 真：</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">银 行：农行上海江桥支行</td>
	    <td style="width:50%;text-align: left;">银 行：</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">帐 号：03827500040059723 </td>
	    <td style="width:50%;text-align: left;">帐 号：  </td>
	  </tr>
	  <tr style="line-height:20px;font-size: 12px;"><td colspan="2"></td>  </tr>
	  <tr style="line-height:20px;font-size: 12px;"><td colspan="2"></td>  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">
              供方代表：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


	    </td>
	    <td style="width:50%;text-align: left;">需方代表：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (盖章)</td>
	  </tr>
	  <tr style="line-height:120%;font-size: 12px;">
	    <td style="width:50%;text-align: left;">

	    </td>
	    <td style="width:50%;text-align: left;"></td>
	  </tr>



	</table>
	<img src="images/cert.png" style="width: 4cm;opacity: 0.7;margin: -2cm 0 0 0.5cm;">
      </div>
    </div>

  </body>
</html>
