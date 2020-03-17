<!DOCTYPE html>
<html>
  <head>
      <title>Cooking Point | 3rd Party Payment</title>
      <meta name="description" content="Payment page for 3rd parties" >      
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" href="{{ config('cookingpoint.favicon') }}">
      <link rel="canonical" href="{{ strtok(url()->current(), '?') }}">
 
      <link href="{{ mix('/css/app.css') }}" rel="stylesheet" type="text/css">     

   		<meta name="robots" content="noindex,nofollow">

      
	</head>
    
<body>

	<div class="row justify-content-center">
		<div class="col-2">
			<p></p>
			<img class="home-logo" alt="Cooking Point" src="/images/cookingpoint_MIC.svg" onerror="this.onerror=null; this.src='/images/cookingpoint_logox75.png'">			
		</div>
	</div>

	<div class="container-fluid">
	    <div class="col-lg-10">
			<div class="row justify-content-center">
				<div class="col-12">

				@if ($tpv_result === 'OK' || $bkg->status === 'PAID')
					<h1>Thank You</h1>
					<p>The payment has been processed. You can print this page as a receipt.<br/></p>
				@elseif ($tpv_result === 'KO')
					<h1>3rd Party Payment Page</h1>
					<p class="bg-warning">Sorry, it seems something went wrong, please try it again.<br/></p>
				@else
					<h1>3rd Party Payment Page</h1>
					<p>According to our agreement, you are required to pay the following services:<br/></p>
				@endif
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col col-xl-10">
						<table class="voucher-table">
							<tbody>
								<tr>
									<td class="font-weight-bold">
										Your Company:
									</td>
									<td>
										{{ $bkg->calendarevent->short_description }}
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">
										Subject:
									</td>
									<td>
										{{ $bkg->name }}
									</td>
								</tr>

								<tr>
									<td class="font-weight-bold">
										Details:
									</td>
									<td>
										{{ $bkg->comments }}
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">
										Invoice #:
									</td>
									<td>
										{{ $bkg->invoice }}
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">
										Amount:
									</td>
									<td>
										 EUR {{ $bkg->price }}
									</td>
								</tr>
								<tr>
									<td class="font-weight-bold">
										Status:
									</td>
									<td>
										 {{ $bkg->status }}
									</td>
								</tr>
							</tbody>
						</table>					
				</div>
			</div>

		@if ($tpv_result === 'OK' || $bkg->status === 'PAID')
			<div class="row justify-content-center">
				<p><br/></p>
				<button class="btn btn-primary" onclick="window.print(); return false;">Print</button>
			</div>
		@else
			<div class="row justify-content-center">
				<div class="col-12">
					<p>Click on "Checkout" to pay through our bank's payment platform.<br/></p>
					<a href="/pay/{{ $bkg->id }}" class="btn btn-primary">Checkout</a>
					<p></p>
				</div>				
			</div>
		@endif
	    </div>  
	  </div>

	</div>


</body>

</html>
