<header class="main-header">

  <!-- Logo -->
  <a href="{{ route("admin.index") }}" class="logo">
    <span class="logo-lg"><b>管理后台</b></span>
  </a>

  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
	<li class="dropdown tasks-menu">
	  <a href="{{ route("admin.todo") }}">
	    <i class="fa fa-flag-o"></i>
	    <span class="label label-danger">{{ 4 }}</span>
          </a>
        </li>

	@if (auth("admin")->check())
	<li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	    <span class="hidden-xs">
	      {{ auth("admin")->user()->name }}
	    </span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-footer">
	      <a href="#">个人信息</a>
	      <a href="{{ route("admin.logout") }}">退出</a>
            </li>
          </ul>
	</li>
	@else
	<li class="dropdown user user-menu">
          <a href="{{ route("admin.login") }}" class="dropdown-toggle">
	    <span class="hidden-xs">
	      登录
	    </span>
          </a>
	</li>
	@endif
      </ul>
    </div>
  </nav>
</header>
