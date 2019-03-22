@extends('admin.adminmasterlayout')

@section('title', 'BlogTool')
@section('description', 'Blog Maintenance')

@section('content')

<div id="post-index-page" class="admin row justify-content-center">
	<div class="col-md-10">

		<h1 class="header1">Posts</h1>
		<p><button class="btn btn-light btn-sm"id="button_post_index_toggle">View: all</button><button class="btn btn-primary btn-sm " style="display:none;" id="button_post_index_save" class="d-none">Save Order</button></p>
		<table class="table table-sm table-hover" id="blogposts_table" data-toggle="ALL">
			<thead>
				<tr>
					<th>Id</th>
					<th>Shortname</th>
					<th>Title</th>
					<th>Friendly URL</th>
					<th>Status</th>
					<th>Actions </th>
				</tr>
			</thead>
			<tbody>
			</tbody>                        
		</table>
	</div>
</div>


@section('modals')
	@include('admin.modals')
@stop

@section('js')
	<script async src="/js/adminblogtool.js"></script>
@stop
@stop