<!DOCTYPE html>
<html lang="en">
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

		<link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     
		<style type="text/css">
		  ul {
				list-style-type: none;
				margin: 0;
				padding: 0;
			  }
		  	body {
		  		font-family: Helvetica, Arial, sans-serif ;
  			}
	  	</style>
		<script type='text/javascript' src='{{ mix('/js/tienda.js') }}'></script>
		<script src="https://use.fontawesome.com/c502308363.js"></script>
	</head>
	
  <body>

	<div class="container">
		<table class="table">
		<tr>
			<td><a class="header1" href="/tienda">SHOP</a></div></td>
			<td><div class="header1 text-center">{{ app('request')->input('user_name') }}&nbsp;&nbsp;<a href="/admin/logout">Logout</a></div></td>
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
