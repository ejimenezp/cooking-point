@extends('admin.adminmasterlayout')

@section('title', 'Edit Post')
@section('description', 'Blog Maintenance')

@section('content')

<div id="post-edit-page" postid="{{ $id }}" class="admin row justify-content-center">

	<div class="col-md-10">
			<h1>Edit Post ({{ $id }})</h1>

			<div class="row">		
				<div class="col-md-6">
					<form id="leftform" class="form-horizontal" role="form" onsubmit="return false;">
			   			{{ csrf_field() }}
			   			<input type="hidden" name="id">
			   			<table class="table table-sm table-borderless">
							<tr>
								<td>
									Shortname:
								</td>
								<td>
									<input name="shortname" type="text" value="" >
								</td>
							</tr>
							<tr>
								<td>
									Title:
								</td>
								<td>
									<input name="title" type="text" value="" >
								</td>
							</tr>
							<tr>
								<td>
									Friendly URL:
								</td>
								<td>
									<input name="friendly_url" type="text" value="" >
								</td>
							</tr>
								<td>
									Description:
								</td>
								<td>
									<textarea name="description" type="text" value="" ></textarea>
								</td>
							</tr>
							<tr>
								<td>
									Status:
								</td>
								<td>
									<input name="status" type="text" value="" >
								</td>								
							</tr>
							<tr>
								<td colspan="2">
									Related Posts:

									<form>
						            <select id="related_posts" name="related[]" multiple="multiple">
						            </select>
									</form>	
								</td>								
							</tr>
			   			</table>

			   		</form>
				</div>

				<div class="col-md-6">
					<form id="rightform" class="form-horizontal" role="form" onsubmit="return false;">
			   			<table class="table table-sm table-borderless">
							<tr>
								<td colspan="2">
									Uploaded files:
									<form>
							            <select id="uploaded_images" name="uploaded[]" multiple="multiple">
							            </select>
    									<button id="button_remove_images" class="btn btn-sm btn-secondary">Remove marked</button>
									</form>	
								</td>
							</tr>
							<tr>	
								<td colspan="2">
									<form id="uploadfiles" method="post" enctype="multipart/form-data">
    									<input type="file" name="image" >
    									<button id="button_upload_image" class="btn btn-sm btn-secondary">Upload</button>
 									</form>
								</td>
							</tr>
							<tr>
								<td>
									Thumbnail img:
								</td>
								<td>
									<select name="thumbnail_image"></select>
								</td>
							</tr>
							<tr>
								<td>
									Thumbnail descr:
								</td>
								<td>
									<textarea name="thumbnail_description"></textarea>
								</td>
							</tr>
							<tr>
								<td>
									Publishing date:
								</td>
								<td>
									<input name="publishing_date" type="text" value="" >
								</td>
							</tr>
			   			</table>
			   		</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<form id="bottomform" class="form-horizontal" role="form" onsubmit="return false;">
			   			<table class="table table-sm table-borderless">
							<tr>
								<td>
									Texto:

									<textarea name="body" rows="12"></textarea>
								</td>
							</tr>
			   			</table>
			   		</form>					
				</div>				
			</div>
			<div class="row justify-content-center">
				<button onclick='location.href="/admin/blogtool"' class="btn btn-secondary">Back</button>
				&nbsp;&nbsp;&nbsp;
				<button onclick='window.open("/admin/blogtool/preview/{{ $id }}")' class="btn btn-primary">Preview</button>
				&nbsp;&nbsp;&nbsp;
				<button id="button_post_update" class="btn btn-primary">Save</button>
				&nbsp;&nbsp;&nbsp;
				<button id="button_post_publish" class="btn btn-primary">Publish</button>
				&nbsp;&nbsp;&nbsp;
				<button id="button_post_delete" class="btn btn-secondary">Delete</button>
			</div>
	</div>	
</div>

@section('modals')
	@include('admin.modals')
@stop

@section('js')
<script async src="/js/admin/blogtool.js"></script>
@stop

@stop
