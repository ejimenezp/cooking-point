@extends('admin.adminmasterlayout')
@section('title', 'Main - Admin Cooking Point')
@section('description', 'Cooking Point Admin Main Page')

@section('content')
<div class="admin row justify-content-center">
	<div id="AdminBookingsRoot" any="{{ $any }}"></div>
</div>
@stop

@section('js')
	<script defer type='text/javascript' src="{{ mix('/js/admin/adminbookings.js') }}"></script>
	@if (App::environment() == 'production')
		<script type="text/javascript">
		if (typeof window.__REACT_DEVTOOLS_GLOBAL_HOOK__ === 'object') {
		  __REACT_DEVTOOLS_GLOBAL_HOOK__.inject = function () {}
		}
		</script>
	@endif
@stop
