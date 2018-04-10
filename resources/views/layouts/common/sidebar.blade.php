<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">产品</li>
      <li>
	<a href="{{ route("admin.brand.index") }}">
	  品牌管理
	</a>
      </li>
      <li>
	<a href="{{ route("admin.storage.index") }}">
	  仓库管理
	</a>
      </li>
      <li>
	<a href="{{ route("admin.category.index") }}">
	  分类管理
	</a>
      </li>
      <li>
	<a href="{{ route("admin.product.index") }}">
	  产品管理
	</a>
      </li>

      <li class="header">订单</li>
      <li>
	<a href="{{ route("admin.order.index") }}">
	  所有订单
	</a>
      </li>
      <li>
	<a href="#">
	  未付款订单
	</a>
      </li>
      <li>
	<a href="#">
	  待发货订单
	</a>
      </li>
      <li>
	<a href="#">
	  已完成订单
	</a>
      </li>
      <li>
	<a href="#">
	  退货订单
	</a>
      </li>

      <li class="header">用户</li>
      <li>
	<a href="#">
	  商城用户
	</a>
      </li>
      <li>
	<a href="#">
	  管理员
	</a>
      </li>
      <li>
	<a href="#">
	  供应商
	</a>
      </li>

      <li class="header">报表</li>
      <li><a href="#">用户</a></li>
      <li><a href="#">销售</a></li>
      <li><a href="#">产品</a></li>
      <li><a href="#">品牌</a></li>

      <li class="header">系统设置</li>
      <li>
	<a href="#">权限</a>
      </li>
      <li>
	<a href="#">系统参数</a>
      </li>

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
