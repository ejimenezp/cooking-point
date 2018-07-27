<!DOCTYPE html>
<html>
  <head>
      <title>Cooking Point | 3rd Party Payment</title>
      <meta name="description" content="Payment page for 3rd parties" >      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="{{ config('cookingpoint.favicon') }}">
      <link rel="canonical" href="{{ strtok(url()->current(), '?') }}">
      <style type="text/css">
          ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
              }
          #map {
                height: 50vh;
                width: 100%;
              }
      </style>  
      <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     
      <script src="https://use.fontawesome.com/c502308363.js"></script>


   		<meta name="robots" content="noindex,nofollow">

      
	</head>
    
<body>

	<div class="row text-center">
	<p></p>
	<img class="home-logo" alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'">
	</div>

	<div class="container-fluid">
	  <div class="no-gutter">
	    <div class="col-sm-12 col-lg-offset-1 col-lg-10">
	      <div class="no-gutter">

			<div class="row">
				<div class="col-sm-12">

				@if ($tpv_result === 'OK' || $bkg->status === 'PAID')
					<h1 class="header1">Thank You</h1>
					<p>The payment has been processed. You can print this page as a receipt.<br/></p>
				@elseif ($tpv_result === 'KO')
					<h1 class="header1">3rd Party Payment Page</h1>
					<p style="background-color: green; color:white;">Sorry, it seems something went wrong, please try it again.<br/></p>
				@else
					<h1 class="header1">3rd Party Payment Page</h1>
					<p>According to our agreement, you are required to pay the following services:<br/></p>
				@endif
				</div>

				<div class="col-md-offset-1 col-md-8">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="bold">
										Your Company:
									</td>
									<td>
										{{ $bkg->calendarevent->short_description }}
									</td>
								</tr>
								<tr>
									<td class="bold">
										Subject:
									</td>
									<td>
										{{ $bkg->name }}
									</td>
								</tr>

								<tr>
									<td class="bold">
										Details:
									</td>
									<td>
										{{ $bkg->comments }}
									</td>
								</tr>
								<tr>
									<td class="bold">
										Invoice #:
									</td>
									<td>
										{{ $bkg->invoice }}
									</td>
								</tr>
								<tr>
									<td class="bold">
										Amount:
									</td>
									<td>
										 EUR {{ $bkg->price }}
									</td>
								</tr>
								<tr>
									<td class="bold">
										Status:
									</td>
									<td>
										 {{ $bkg->status }}
									</td>
								</tr>
							</tbody>
						</table>
					
				</div>

		@if ($tpv_result === 'OK' || $bkg->status === 'PAID')

			</div>
			<div class="row text-center">
				<p><br/></p>
				<button class="btn btn-primary" onclick="window.print(); return false;">Print</button>
			</div>
		@else
				<div class="col-sm-12">
					<p></p>
					<p>Click on "Checkout" to pay through our bank's payment platform.<br/><br/></p>
				</div>

			</div>
			<div class="row text-center">
				<a href="/pay/{{ $bkg->id }}" class="btn btn-primary">Checkout</a>
			</div>				
		@endif
	      </div>
	    </div>  
	  </div>

	</div>


	<!-- javascripts specific for this page  -->
	@yield('js')

</body>

</html>
