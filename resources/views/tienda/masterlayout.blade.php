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
		<script type='text/javascript' src='/js/tienda.js'></script>
		<script src="https://use.fontawesome.com/c502308363.js"></script>
	</head>
	
  <body>

	<div class="container">
		<table class="table">
		<tr>
			<td><h2><a href="/tienda">SHOP</a></div></h2></td>
			<td><h2><div class="text-center">{{ app('request')->input('user_name') }}&nbsp;&nbsp;<a href="/admin/logout">Logout</a></div></h2></td>
			<td style="vertical-align: middle;"><input type="text" name="pretty_date" id="admindatepicker"></td>
		</tr>
		</table>
	</div>
	<div class="divider"></div>

<!-- main area -->
@yield('content')	

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
