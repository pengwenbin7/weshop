# weshop数据模型

## 环境准备

### 测试环境为：

-   ubuntu 16.04 x64
-   nginx 1.13
-   mariadb 10.2
-   php 7.2
-   redis 4.0
-   beanstalkd 1.10
-   supervisor 3.2
-   laravel 5.6

[安装问题](https://laravel-china.org/docs/laravel/5.6/installation)

### 安装的扩展：

-   "predis/predis": "^1.1" (redis 驱动)
-   "pda/pheanstalk": "^3.1" (heanstalkd 驱动)
-   "barryvdh/laravel-debugbar": "^3.1" (debug)

> 不建议用 redis 作为队列驱动 [知乎讨论](https://www.zhihu.com/question/20795043)

## 数据模型

所有表主键均为 id，都包含 'created\_at' 和 'updated\_at' 字段，省略了用户、供应商、产品分类等表

    addresses:        // 地址表
            +country      // + 表示可选，如果有“多国家”的设计有此字段
             province     // 省
             city         // 市
            +district     // 区
            +stree        // 街道
             detail       // 详细
            +longitude    // 经度，如果需要估算距离有此字段
            +latitude     // 维度，如果需要估算距离有此字段
    
    brands:           // 品牌表
             name         // 名字
            +supplier_id  // 如果有“供应商”的设计有此字段，供应商 id
    
    storages:       // 仓库表
             name
            -address_id // - 表示外键，仓库 id
    
    products:       // 产品表
             name
            -brand_id
            -storage_id
             stock      // 库存
             price      //单价
    
    carts:              // 购物车表
            -product_id
             product_name   // 产品名副本
             product_price  // 加入购物车时的单价
             number         // 加入的数量
    
    orders:               // 订单表
            -user_id          // 下单用户
            -user_address_id  // 收货地址
            -payment_id       // 付款单 id
            -shipment_id      // 物流单 id
            -refund_id        // 退款退货单 id
            +coupon_id        // 优惠券
            +tax_id           // 税
            +admin_id         // 跟进员
             active           // 是否可用
    
    order_item:        // 订单条目表
            -order_id
             product_name
             brand_name
             storage_name
             number
             price
            +product_id    // 如果需要在订单页跳转到商品页有此字段
            -storage_id
    
    payments:        // 付款单表
             status      // 付款状态
             pay_time    // 付款时间
    
    shipments:         // 物流单表
             status        // 物流状态      
    
    shipment_item:        // 物流条目表
            -shipment_id
             ship_no          // 物流单号
            -from_address_id
            -to_address_id
            +cartage          // 运费
    
    pay_refunds:           // 退款表
            -order_item_id
             type              // 退款或退货
             status
             user_status       // 用户发起或取消
             shop_status       // 商家同意或驳回
             user_product_time // 用户确认退货时间
             shop_prodcut_time // 商家确认退货时间
             shop_pay_time     // 商家确认退款时间
             user_pay_time     // 用户确认退款时间
