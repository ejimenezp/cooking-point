<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>TPV Stub</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

     </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    TPV Stub
                </div>

<?php
	$params = json_decode($Ds_MerchantParameters, true);
?>

                <p>{{ $Ds_MerchantParameters }}</p>
                <p>{{ $params['DS_MERCHANT_PRODUCTDESCRIPTION'] }}</p>
                <form action='/tpv-stub-reply' method="post">
                	@csrf
                	<input type="hidden" name="callback" value="{{ $params['DS_MERCHANT_MERCHANTURL'] }}">
                	<input type="hidden" name="Ds_MerchantData" value="{{ $params['DS_MERCHANT_MERCHANTDATA'] }}">
                	<select name="action">
                		<option value="{{ $params['DS_MERCHANT_URLOK'] }}">OK</option>
                		<option value="{{ $params['DS_MERCHANT_URLKO'] }}">Fail</option>
                	</select>
                	<label>Response</label>
                	<input type="text" name="DS_Response" value='0000'>
                	<button type="submit">Send</button>
                </form>


            </div>
        </div>
    </body>
</html>

