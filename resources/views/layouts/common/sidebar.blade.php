<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">
	<a href="{{ route('admin.todo') }}">todo</a>
      </li>
      
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
	<a href="{{ route("admin.order.mine") }}">
	  我的订单
	</a>
      </li>

      @can("order", "admin")
      <li>
	<a href="{{ route("admin.order.index") }}">
	  所有订单
	</a>
      </li>
      @endcan

      @can("ship", "admin")
      <li>
	<a href="{{ route("admin.shipment.index") }}">
	  发货单
	</a>
      </li>
      @endif

      <li class="header">用户</li>
      <li>
	<a href="#">
	  我的用户
	</a>
      </li>

      @can("user", "admin")
      <li>
	<a href="#">
	  商城用户
	</a>
      </li>
      @endcan

      @can("system", "admin")
      <li>
	<a href="#">
	  管理员
	</a>
      </li>
      @endcan

      @can("supplier", "admin")
      <li>
	<a href="#">
	  供应商
	</a>
      </li>
      @endcan

      @can("report", "admin")
      <li class="header">报表</li>
      <li><a href="#">用户</a></li>
      <li><a href="#">销售</a></li>
      <li><a href="#">产品</a></li>
      <li><a href="#">品牌</a></li>
      @endcan

      @can("system", "admin")
      <li class="header">系统设置</li>
      <li>
	<a href="#">权限</a>
      </li>
      <li>
	<a href="#">系统参数</a>
      </li>
      @endcan

    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
