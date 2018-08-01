<!DOCTYPE html>
<html lang="es">
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
    			font-size: 16px !important;
  			}
	  	</style>  
		<script type='text/javascript' src='{{ mix('/js/admin.js') }}'></script>
		<script src="https://use.fontawesome.com/c502308363.js"></script>
	</head>
	
  <body>

	<div class="loading loading-backdrop">
		<div class="progress-box">
			<div class="progress"><div>Loading…</div></div>				
		</div>
	</div>


	<div class="container">
		<div class="d-block d-lg-none">
		  <nav class="navbar">
		    <a class="header2" data-toggle="collapse" data-target="#navbar" href="#">
              Menu <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
            <span class="pull-right"><button id="toggle_datepicker" class="btn btn-xs btn-default">Calendario</button></span>
	    	<div id="navbar" class="collapse navbar-collapse">
	          	<ul class="nav navbar-nav">
		            <li>
		              <a href="/admin">Admin</a>
		            </li>
		            <li>
		              <a href="/admin/report">Reports</a>
		            </li>
		            <li>
		              <a href="#" onclick="location.reload();return false">Actualizar</a>
		            </li>
		            <li>
		              <a href="/admin/logout">Salir</a>
		            </li>
          		</ul>
          	</div>
          </nav>
        </div>

		<div class="d-none d-lg-block">
		  	<nav class="navbar">
	          	<ul class="nav">
		            <li class="nav-item"> 
		              <a class="nav-link" href="/admin">Admin</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="/admin/report">Reports</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="#" onclick="location.reload();return false">Actualizar</a>
		            </li>
		            <li class="nav-item">
		              <a class="nav-link" href="/admin/logout">Salir</a>
		            </li>
           		</ul>
			</nav>
	    </div>
        </div>

		<div class="divider"></div>

<!-- main area -->
		@yield('content')	

		<br/>
		<br/>

	</div>

<!-- modals specific for this page  -->
@yield('modals')

<!-- javascripts specific for this page  -->
@yield('js')

</body>

</html>
