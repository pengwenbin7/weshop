<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      @if (auth("admin")->user()->can("product"))
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
      @endif

      <li class="header">订单</li>
      <li>
	<a href="{{ route("admin.order.mine") }}">
	  我的订单
	</a>
      </li>

      @if (auth("admin")->user()->can("order"))
	<li>
	  <a href="{{ route("admin.order.index") }}">
	    所有订单
	  </a>
	</li>
      @endif

      @if (auth("admin")->user()->can("ship"))
	<li>
	  <a href="{{ route("admin.shipment.index") }}">
	    发货单
	  </a>
	</li>
      @endif

      @if (auth("admin")->user()->can("pay"))
	<li>
	  <a href="{{ route("admin.invoice.index") }}">
	    发票
	  </a>
	</li>
      @endif

      <li class="header">用户</li>
      <li>
	<a href="{{ route("admin.meuser.index") }}">
	  我的用户
	</a>
      </li>

      @if (auth("admin")->user()->can("user"))
	<li>
	  <a href="{{ route("admin.shopuser.index") }}">
	    商城用户
	  </a>
	</li>
      @endif

      @if (auth("admin")->user()->can("system"))
	<li>
	  <a href="#">
	    管理员
	  </a>
	</li>
      @endif

      @if (auth("admin")->user()->can("supplier"))
	<li>
	  <a href="#">
	    供应商
	  </a>
	</li>
      @endif

      @if (auth("admin")->user()->can("report"))
	<li class="header">报表</li>
	<li><a href="#">用户</a></li>
	<li><a href="#">销售</a></li>
	<li><a href="#">产品</a></li>
	<li><a href="#">品牌</a></li>
      @endif

      @if (auth("admin")->user()->can("system"))
	<li class="header">系统设置</li>
	<li>
	  <a href="#">权限</a>
	</li>
	<li>
	  <a href="{{ route("admin.system.index") }}">系统参数</a>
	</li>
      @endif

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
