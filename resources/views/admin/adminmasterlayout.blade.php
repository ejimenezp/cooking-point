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
	<div class="loading" style="display:none">Loading&#8230;</div>
	<div class="container">

	  <div class="row no-gutter">   
		  <div class="col-sm-12">
			<ul class="nav navbar-nav">
				<li>
					<a href="/admin/calendarevent">Home</a>
				</li>
				<li>
					<a href="/admin/logout">Salir</a>
				</li>
			</ul>
		  </div>      
	  </div>
		
<!-- main area -->

@yield('content')


<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>