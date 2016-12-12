<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta name="description" content="@yield('description')" >
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="user_name" content="{{ app('request')->input('user_name') }}">
		<meta name="user_role" content="{{ app('request')->input('user_role') }}">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="/images/favicon-admin.ico">
		<link rel="canonical" href="{{ url()->current() }}">
		<style type="text/css">
		  ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
			  }
	  	</style>  
		<link href="{{ elixir('css/app.css') }}" rel="stylesheet" type="text/css">     
		<script type='text/javascript' src='/js/admin.js'></script>
		<script src="https://use.fontawesome.com/c502308363.js"></script>
	</head>
	
  <body>

	<div class="loading loading-backdrop">
		<div class="progress-box">
			<div class="progress"><div>Loading…</div></div>				
		</div>
	</div>


	<div class="container">
		<div class="text-center">
			<h4><a href="#" onclick="location.reload();return false">Actualizar</a>&nbsp;&nbsp;<a href="/admin/logout">Salir</a>
				<span class="pull-right"><button id="toggle_datepicker" class="btn btn-xs btn-default">Calendario</button></span></h4>  	
		</div>
		<div class="divider"></div>

<!-- main area -->
		@yield('content')	

	</div>

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
