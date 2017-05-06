<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('custom.title') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		
		    <!-- Bootstrap Core CSS -->
		<link href="{{ url('/') }}/css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="{{ url('/') }}/css/metisMenu.min.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="{{ url('/') }}/css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="{{ url('/') }}/css/startmin.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<link href="{{ url('/') }}/css/morris.css" rel="stylesheet">
		
		<link href="{{ url('/') }}/css/bootstrap-table.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="{{ url('/') }}/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		
		<link href="{{ url('/') }}/css/common.css" rel="stylesheet">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="{{ url('/') }}/js/html5shiv.js"></script>
		<script src="{{ url('/') }}/js/respond.min.js"></script>
		<![endif]-->
		
		<style>
		 .navbar {
			background-color: #23527c !important;
		 }
		 
		 .navbar-brand, .navbar-dropdown {
			color: #fff !important;
		 }
		 
		 .navbar-dropdown:hover {
			background-color: #e62e00 !important; 
		 }
		 
		 .actives {
			background-color: #66ccff !important;
			color: #fff !important;
		 }
		 
		 .dropdown-toggle {
			 color: #000 !important;
		 }
		 
		 .form-row-gap {
		  padding-bottom: 10px;
		}

		.form-row-gap-internal {
		  padding-bottom: 2px;
		}
		
		.content-align-right {
			text-align: right;
			padding-left: 1px;
		}
		</style>
		
		<script>
			var BASEURL = '<?php echo url('/'); ?>';
		</script>
				
		<!-- jQuery -->
		<script src="{{ url('/') }}/js/jquery.min.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="{{ url('/') }}/js/bootstrap.min.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="{{ url('/') }}/js/metisMenu.min.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="{{ url('/') }}/js/startmin.js"></script>
		
		<script src="{{ url('/') }}/js/bootstrap-table.js"></script>
		
		<script src="{{ url('/') }}/js/common.js"></script>
		
		<!--<script src="{{ url('/') }}/js/dataTables/dataTables.bootstrap.min.js"></script>
		
		<script src="{{ url('/') }}/js/dataTables/jquery.dataTables.min.js"></script>-->
    </head>
    <body>
	@foreach ($employeeInfo as $empInfo)  

	<div id="wrapper">

			<!-- Navigation -->
			<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">{{ config('custom.title') }}</a>
				</div>

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<!-- Top Navigation: Right Menu -->
				<ul class="nav navbar-right navbar-top-links">
					<li class="dropdown">
						<a class="navbar-dropdown" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> {{$empInfo->emp_firstname}}&nbsp;{{$empInfo->emp_lastname}} <b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
							</li>
							<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
							</li>
							<li class="divider"></li>-->
							<li><a href="logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
							</li>
						</ul>
					</li>
				</ul>

				<!-- Sidebar -->
				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">

						<ul class="nav" id="side-menu">
							<li>
								<a href="dashboard" class="@yield('dashboardActive')"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-users fa-fw"></i> Employees<span class="fa arrow"></a>
								<ul class="nav nav-second-level">
									@if($empInfo->emp_type == '1')
										<li>
											<a href="employee" class="@yield('employeeActive')">Manage Employee</a>
										</li>
									@endif
									<li>
										<a href="attendance" class="@yield('attendanceActive')">Manage Attendance</a>
									</li>
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-users fa-fw"></i> Customers<span class="fa arrow"></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="customer" class="@yield('customerActive')">Manage Customer</a>
									</li>									
								</ul>
							</li>
							<li>
								<a href="#"><i class="fa fa-product-hunt fa-fw"></i> Products<span class="fa arrow"></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="products" class="@yield('productActive')">Manage Product</a>
									</li>									
								</ul>
							</li>
							<li>
								<a href="report" class="@yield('reportActive')"><i class="fa fa-file-text-o fa-fw"></i> Reports</a>
							</li>
							<li>
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Additional<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a href="productType" class="@yield('productTypeActive')">Manage Product Types</a>
									</li>
									<li>
										<a href="vehicle" class="@yield('vehicleActive')">Manage Vehicles</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			<!-- Page Content -->
			<div id="page-wrapper">
				<div class="container-fluid">

					<div class="row">
						<h4 class="page-header">@yield('breadcrum')</h4>
					</div>
					
					<div class="row">
						@yield('content')
					</div>
					
				</div>
			</div>

		</div>
	@endforeach
    </body>

</html>
