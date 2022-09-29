<!DOCTYPE html>
<html lang="es">

<head>
	<title>Main - Admin Cooking Point</title>
	<meta name="description" content="Cooking Point Admin Main Page">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="user_name" content="{{ app('request')->input('user_name') }}">
	<meta name="user_role" content="{{ app('request')->input('user_role') }}">
	<meta name="staff_id" content="{{ app('request')->input('cpuser') }}">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ config('cookingpoint.adminfavicon') }}">
	<link rel="canonical" href="{{ url()->current() }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>

	<div id="AdminBookingsReactRoot" param="{{ $param ?? '' }}" date="{{ $date ?? '' }}"></div>

	<script defer type='text/javascript' src="{{ mix('/js/admin/adminbookingsreactroot.js') }}"></script>
	@if (App::environment() == 'production')
		<script type="text/javascript">
			if (typeof window.__REACT_DEVTOOLS_GLOBAL_HOOK__ === 'object') {
			  __REACT_DEVTOOLS_GLOBAL_HOOK__.inject = function () {}
			}
		</script>
	@endif
	
</body>

</html>
