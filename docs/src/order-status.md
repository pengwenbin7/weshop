# weshop订单状态

## 字段

-   status 订单状态

> 0 - 待处理
> 
> 1 - 处理中
> 
> 2 - 正常完成
> 
> 3 - 异常完成

-   pay\_status 付款状态

> 0 - 待付款
> 
> 1 - 部分付款
> 
> 2 - 完成付款
> 
> 3 - 退款

-   ship\_status 发货状态

> 0 - 待发货
> 
> 1 - 部分发货
> 
> 2 - 已发货
> 
> 3 - 已确认

-   refund\_status 退货状态

> 1 - 退货中
> 
> 2 - 等待退货
> 
> 3 - 退货完成

-   active 活动标志

> 0 - 可以修改订单
> 
> 1 - 锁定订单，不可修改

## 状态转换

分期付款和部分发货的功能暂未实现
-   user\_op 用户可以进行的下一步操作
-   admin\_op 管理员可以进行的下一步操作
-   system\_op 系统可以进行的下一步操作

<table border="2" cellspacing="0" cellpadding="6" rules="groups" frame="hsides">


<colgroup>
<col  class="left" />

<col  class="right" />

<col  class="right" />

<col  class="right" />

<col  class="right" />

<col  class="right" />

<col  class="left" />

<col  class="left" />

<col  class="left" />
</colgroup>
<thead>
<tr>
<th scope="col" class="left">已完成的状态</th>
<th scope="col" class="right">status</th>
<th scope="col" class="right">pay\_status</th>
<th scope="col" class="right">ship\_status</th>
<th scope="col" class="right">refund\_status</th>
<th scope="col" class="right">active</th>
<th scope="col" class="left">user\_op</th>
<th scope="col" class="left">admin\_op</th>
<th scope="col" class="left">system\_op</th>
</tr>
</thead>

<tbody>
<tr>
<td class="left">客户下单</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">取消/付款</td>
<td class="left">修改价格</td>
<td class="left">自动取消订单/确定线上付款</td>
</tr>


<tr>
<td class="left">线上付款</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">null</td>
<td class="left">null</td>
<td class="left">自动发货</td>
</tr>


<tr>
<td class="left">线下付款</td>
<td class="right">1</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">null</td>
<td class="left">确认收款</td>
<td class="left">null</td>
</tr>


<tr>
<td class="left">已失效</td>
<td class="right">3</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">删除</td>
<td class="left">null</td>
<td class="left">null</td>
</tr>


<tr>
<td class="left">付款未发货</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">催货/退款</td>
<td class="left">发货</td>
<td class="left">退款/自动发货</td>
</tr>


<tr>
<td class="left">已退款</td>
<td class="right">3</td>
<td class="right">2</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="left">null</td>
<td class="left">null</td>
<td class="left">null</td>
</tr>


<tr>
<td class="left">已发货</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">2</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">确认收货</td>
<td class="left">null</td>
<td class="left">自动确认收货</td>
</tr>


<tr>
<td class="left">确认收货</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">0</td>
<td class="right">1</td>
<td class="left">退货</td>
<td class="left">null</td>
<td class="left">锁定订单</td>
</tr>


<tr>
<td class="left">已锁定</td>
<td class="right">2</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="left">null</td>
<td class="left">null</td>
<td class="left">null</td>
</tr>


<tr>
<td class="left">发起退货</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">1</td>
<td class="right">1</td>
<td class="left">取消退货</td>
<td class="left">同意退货</td>
<td class="left">自动同意退货</td>
</tr>


<tr>
<td class="left">取消退货</td>
<td class="right">2</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">0</td>
<td class="right">0</td>
<td class="left">null</td>
<td class="left">null</td>
<td class="left">null</td>
</tr>


<tr>
<td class="left">等待退货</td>
<td class="right">1</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">2</td>
<td class="right">1</td>
<td class="left">取消退货/生成退货单</td>
<td class="left">null</td>
<td class="left">自动取消退货</td>
</tr>


<tr>
<td class="left">退货完成</td>
<td class="right">3</td>
<td class="right">2</td>
<td class="right">3</td>
<td class="right">3</td>
<td class="right">0</td>
<td class="left">null</td>
<td class="left">null</td>
<td class="left">自动</td>
</tr>
</tbody>
</table>

-   仅在订单未开始处理(status = 0)的情况下用户/系统可以另其作废
-   仅在订单已付款(pay\_status = 2)且未发货(ship\_status = 0)的情况下，用户可以退款
-   仅在订单作废(status = 3)且未付款(pay\_status = 0)的情况下，用户可以删除
-   发起退货后再取消时，订单进入正常结束状态并锁定
