<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? "Admin" }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/ionic/1.3.2/css/ionic.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/AdminLTE.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/admin-lte/2.4.3/css/skins/skin-blue.min.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield("style")
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      @include("layouts.common.header")
      @include("layouts.common.sidebar")
      <div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	    {{ $page_title ?? "Page Title" }}
	    <small>{{ $page_description or null }}</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
	    <li class="active">Here</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content container-fluid">
	  @yield('content')
	</section>
      </div>

      @include("layouts.common.footer")

      <aside class="control-sidebar control-sidebar-dark">
	<!-- Create the tabs -->
	<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
	  <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
	  <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
	</ul>
	<!-- Tab panes -->
	<div class="tab-content">
	  <!-- Home tab content -->
	  <div class="tab-pane active" id="control-sidebar-home-tab">
	    <h3 class="control-sidebar-heading">Recent Activity</h3>
	    <ul class="control-sidebar-menu">
	      <li>
		<a href="javascript:;">
		  <i class="menu-icon fa fa-birthday-cake bg-red"></i>

		  <div class="menu-info">
		    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

		    <p>Will be 23 on April 24th</p>
		  </div>
		</a>
              </li>
            </ul>
	    <!-- /.control-sidebar-menu -->

	    <h3 class="control-sidebar-heading">Tasks Progress</h3>
	    <ul class="control-sidebar-menu">
	      <li>
		<a href="javascript:;">
		  <h4 class="control-sidebar-subheading">
		    Custom Template Design
		    <span class="pull-right-container">
		      <span class="label label-danger pull-right">70%</span>
                    </span>
		  </h4>

		  <div class="progress progress-xxs">
		    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
		  </div>
		</a>
              </li>
            </ul>
	    <!-- /.control-sidebar-menu -->

	  </div>
	  <!-- /.tab-pane -->
	  <!-- Stats tab content -->
	  <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
	  <!-- /.tab-pane -->
	  <!-- Settings tab content -->
	  <div class="tab-pane" id="control-sidebar-settings-tab">
	    <form method="post">
	      <h3 class="control-sidebar-heading">General Settings</h3>

	      <div class="form-group">
		<label class="control-sidebar-subheading">
		  Report panel usage
		  <input type="checkbox" class="pull-right" checked>
		</label>

		<p>
		  Some information about this general settings option
		</p>
              </div>
	      <!-- /.form-group -->
            </form>
	  </div>
	  <!-- /.tab-pane -->
	</div>
      </aside>
      <div class="control-sidebar-bg"></div>
    </div>

    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/admin-lte/2.4.3/js/adminlte.min.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.5.16/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/axios/0.18.0/axios.min.js"></script>
    @yield("script")
  </body>
</html>
