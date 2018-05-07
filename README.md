# INSTALL
require:
+ mysql > 5.7.7
+ php > 7.2.0

```shell
composer install
php artisan migrate
php artisan db:seed
php artisan region:update
php artisan adminuser:init
```
现在，可以简单的使用
	make  # 安装
	make clean  # 反安装

待实现：
	+ 订单页分享减免
	+ 管理员消息(可直接跳转到对应操作页面)
	+ 处理客户反馈
	+ 发货
	+ 退款(考虑额度)
	+ 红包(暂时无法自动，考虑替代方案)

暂不实现:
	+ 当部门信息更新时，更新权限才对
	+ 退货流程
