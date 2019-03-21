<!DOCTYPE html>
<html>
	<head>
		<title>Emails - Admin Cooking Point</title>
		<meta name="description" content="Guests E-mail Gathering" >
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
		<link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     
		<script type='text/javascript' src='{{ mix("/js/classemails.js") }}'></script>
		<script src="https://use.fontawesome.com/c502308363.js"></script>
	</head>
	
  <body>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-sm-10">
				<form id="classemails_form" method='post'>
					{{ csrf_field() }}

					<h1 class="header1"><div class="dateshown"></div></h1>
					<h4><div class="classshown"></div></h4>
					<p>
						Dear guest,<br/>
						<br/>
						We'd like to send you an email tomorrow, to kindly ask you to review us online. For that reason, we are asking you to add your email address if it is not on the table.<br/><br/>
						Thank you very much in advance.
					</p>
					<table class="table" id="classemails_table">
					    <thead>
					    	<tr>
					    		<th>Guests</th>
					    		<th>Name</th>
					    		<th>E-mail</th>
					    		<th></th>
				    		</tr>
						</thead>
					    <tbody>
					    </tbody>                        
					</table>
				</form>
			</div>
		</div>

	</div>

</body>

</html>
