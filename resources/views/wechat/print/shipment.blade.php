<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>货号:{$delivery_order.delivery_sn}</title>
    <style>
      *{margin:0;padding:0}
      ul,ol,dl,li,dd,dt{list-style: none;}
      body{ font-size:12px;}
      h3{font-size: 23px; font-size:20px; font-weight: normal;}
      h4{font-size: 20px; text-align: center;}
      h5{line-height: 20px; font-weight: normal;}
      h5 span {float: none; width:auto; font-size: 14px;}
      .header{ height:70px; padding:15px 0 0 0; margin: 0 auto; width:700px;position: relative;}
      .company_info{height:60px;}
      .company_info .logo{ margin-right:30px; width: 160px; height: 60px; background:url("../../images/printlogo.png") ; display: inline-block; float: left;}
      .company_info .info{ height: 50px; margin-left:8px; float: left;}
      .header ul li{white-space:nowrap;}
      .order_info{ width: 700px; margin: 0 auto; }
      span{ display:inline-block; width:40%; font-size: 13px; float: left; }
      span.w50{ width: 50%;}
      span.w52{ width: 52%;}
      span.w40{ width: 40%;}
      span.w30{ width: 30%;}
      span.w20{ width: 20%;}
      span.w28{ width: 28%;}
      .order_info ul{margin-top:10px;}
      .order_info ul li{ line-height: 22px;}
      .order_info ul.t10{margin-top:10px;}
      .order_info tr td{line-height: 22px; font-size: 13px;}
      .header .w{ position: absolute; top: 70px; right: -30px; width:12px; }
      .header .r{ position: absolute; top: 140px; right: -30px; width:12px;}
        .header .b{ position: absolute; top: 210px; right: -30px; width:12px;}
        .header .g{ position: absolute; top: 270px; right: -30px; width:12px;}
        .header .y{ position: absolute; top: 330px; right: -30px; width:12px;}

    </style>
  </head>
  <body>
    <div class="header">
      <div class="company_info">
        <div class="logo">
          <img src="../../images/printlogo.png" />
        </div>
        <div class="info">
          <h3>马蜂科技(上海)有限公司<i style="text-align: center; float: right; font-size: 14px;font-weight: normal;">货号:{$delivery_order.delivery_sn}</i></h3>
          <h5>上海江桥嘉怡路279弄147号&nbsp;<span>www.taihaomai.com</span>&nbsp; E-mail:<span>leo@taihaomai.com</span>&nbsp;</h5>
          <h5>电话 : 86-21-69000038&emsp;传真 : 86-21-69000037&nbsp;全国免费客服电话 : 400-9955-699</h5>
        </div>
      </div>

      <!--<ul>
        <li>上海市嘉定区嘉怡路279弄147号 电话 : 86-21-69000038&emsp;传真 : 86-21-69000037</li>
        <li>www.taihaomai.com E-mail:leo@taihaomai.com 全国免费客服电话 : 400-9955-699</li>
      </ul>-->
      {if $bill eq 0}
      <div class="w">白底</div>
      <div class="r">红财</div>
      <div class="b">蓝仓</div>
      <div class="g">绿客</div>
      <div class="y">黄账</div>
      {/if}
    </div>
    <div class="order_info">
      {if $bill eq 0}
      <h4>送&emsp;&emsp;&emsp;货&emsp;&emsp;&emsp;单</h4>
      {else}
      <h4>提&emsp;货&emsp;确&emsp;认&emsp;单</h4>
      {/if}
      <ul>
        {if $bill eq 0}
        <li>
          <span class="w52">收货单位 : {$delivery_order.company_name|default:个人}</span>
          <span class="w28">收货人: {$delivery_order.consignee}({$delivery_order.mobile}) </span>
          <span class="w20">日&emsp;期 : {$date}</span>
        </li>
        <li>
          <span class="w52">收货地址 : {$delivery_order.region}{$delivery_order.address}</span>
          <span class="w28">承运人: {$delivery_order.driver_license|default:无} </span>
          <span class="w20">车&emsp;号 : {$delivery_order.plate_number|default:无}</span>
        </li>
        {else}
        <li>
          <span class="w50">车号 : {$delivery_order.plate_number|default:无}</span>
          <span class="w50">驾照: {$delivery_order.driver_license|default:无} </span>
        </li>
        {/if}
      </ul>

      <table width="100%" border="1" style="border-collapse:collapse;border-color:#000;">
          <tbody>
              <tr align="center">
                  <td>项目类别 </td>
                  <td>商品型号</td>
                  <td>单位 </td>
                  <td>数量</td>
                  {if $bill eq 0}
                  <td>总计</td>
                  {else}
                  <td>商品总重量</td>
                  {/if}
              </tr>

            {foreach from=$goods_list item=g}
              <tr>
                  <td align="center">{$g.goods_name}</td>
                  <td align="center">{$g.model}</td>
                  <td align="center">{$g.measure_unit}</td>
                  <td align="center">{$g.send_number}</td>
                  {if $bill eq 0}
                  <td align="center">{$g.goods_price}&nbsp;</td>
                  {else}
                  <td align="center">{$g.all_weight}KG&nbsp;</td>
                  {/if}
              </tr>
              {/foreach}
          {if $bill eq 0}
          <tr>
            <td colspan="1" align="center">运&nbsp;&nbsp;费</td>

                  <td colspan="4" align="right">{$delivery_order.shipping_fee}&nbsp;</td>
          </tr>
              <tr>
                <td colspan="1" align="center">合&nbsp;&nbsp;计</td>

                  <td colspan="3" align="center">大写 : {$rmb} </td>

                  <td colspan="1" align="right">小写 : {$allmoney}&nbsp;</td>
              </tr>
              {/if}
          </tbody>
      </table>
      <ul class="t10">
        <li>条款 :1. 对于以上化工品的适应性是否符合贵公司要求,请在收货检验后签收,如签收后有异议请在货物签收3个工作日内提出 。
          <br />&emsp;&emsp;&emsp;2. 请核对商品型号及数量后盖章签收,以上条款马蜂公司拥有最终解释权。
        </li>
        <li>&emsp;&emsp;&emsp;收货单位签字(盖章) :&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;审核 : &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;送货单位签字(盖章) :</li>
      </ul>

    </div>

  </body>
</html>
