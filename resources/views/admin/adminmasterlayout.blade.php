<!DOCTYPE html>
<html lang="es">

<head>
	<title>@yield('title')</title>
	<meta name="description" content="@yield('description')">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="user_name" content="{{ app('request')->input('user_name') }}">
	<meta name="user_role" content="{{ app('request')->input('user_role') }}">
	<meta name="staff_id" content="{{ app('request')->input('cpuser') }}">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/images/favicon-admin.ico">
	<link rel="canonical" href="{{ url()->current() }}">
	<link defer href="{{ mix('/css/admin/admin.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
	<div class="d-block d-md-none">
		<div class="cp-smartphone-navbar clearfix">
			<div class=" float-left">
				<a class='menu-strips' href='javascript:void(0);'><img src="/images/icons/menu-strips.png" height="50px" /></a>
			</div>
			<div id="dropdown-content">
				<ul>
					<li>
						<a href="/admin/bookings">Bookings</a>
					</li>
					@if (app('request')->input('user_role') >= 2)
					<li>
						<a href="/admin/report">Reports</a>
					</li>
					<li>
						<a href="/admin/tienda">Tienda</a>
					</li>
					<li>
						<a href="/admin/cashbox">Caja</a>
					</li>
					@endif
					@if (app('request')->input('user_role') >= 3)
					<li>
						<a href="/admin/blogtool">Blog</a>
					</li>
					@endif
					<li>
						<a href="/admin/logout">Salir</a>
					</li>
					<li>
						<a href="/admin" style="color:black;">{{ app('request')->input('user_name') }}</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="navbar-offset"></div>
	</div>
	<!-- ipad landscape & desktop -->
	<div class="d-none d-md-block">
		<div class="cp-navbar">
			<div class="menu clearfix">
				<ul>
					<li>
						<a href="/admin/bookings">Bookings</a>
					</li>
					@if (app('request')->input('user_role') >= 2)
					<li>
						<a href="/admin/report">Reports</a>
					</li>
					<li>
						<a href="/admin/tienda">Tienda</a>
					</li>
					<li>
						<a href="/admin/cashbox">Caja</a>
					</li>
					@endif
					@if (app('request')->input('user_role') >= 3)
					<li>
						<a href="/admin/blogtool">Blog</a>
					</li>
					@endif
					<li>
						<a href="/admin/logout">Salir</a>						
					</li>
					<li>
						<a href="/" style="background-color:lightgrey; color:black;">{{ app('request')->input('user_name') }}</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="divider"></div>
		<div class="row justify-content-center">
			<div class="col-12 col-xl-10">
				@yield('content')
			</div>
		</div>
	</div>
	<!-- modals specific for this page  -->
	@include('admin.modals')
	@yield('modals')
	<!-- javascripts specific for this page  -->
	<script defer type='text/javascript' src="{{ mix('/js/admin/admin.js') }}"></script>
	@yield('js')
</body>

</html>
