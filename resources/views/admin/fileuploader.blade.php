@extends('admin.adminmasterlayout')

@section('title', 'Upload File')
@section('description', 'File upload tool')

@section('content')

<div id="file-upload-page" class="admin row justify-content-center">

	<div class="col-md-10">
			<h1>File Uploader</h1>

			<div class="row">		
				<div class="col-md-6">
					<form id="leftform" class="form-horizontal" role="form" onsubmit="return false;">
			   			<table class="table table-sm table-borderless">
			   				<tr>
			   					<td>
									<form id="uploadfiles" method="post" enctype="multipart/form-data">
										<input type="file" name="file" >
										<button id="button_upload_file" class="btn btn-sm btn-primary">Upload</button>
									</form>			   						
			   					</td>
							</tr>
							<tr>
								<td>
									Uploaded files:
							            <select id="uploaded_files" name="uploaded[]" multiple="multiple">
							            </select>
							            <button id="button_preview_file" class="btn btn-sm btn-primary">Preview</button>
    									<button id="button_remove_files" class="btn btn-sm btn-secondary">Remove marked</button>
								</td>
							</tr>
							<tr>	



			   			</table>
			   		</form>

				</div>

				<div class="col-md-6">
					<form id="rightform" class="form-horizontal" role="form" onsubmit="return false;">
			   			<table class="table table-sm table-borderless">
							<tr>
								<td>
									Preview:

									<textarea name="preview" rows="12" style="overflow-x: auto; line-break: anywhere; height: 281px;font-size: smaller;"></textarea>
								</td>
							</tr>

			   			</table>
			   		</form>
				</div>
			</div>

			<div class="row justify-content-center">
				<button onclick='history.back();' class="btn btn-secondary">Back</button>
				&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;
				<button id="button_import_staffing" class="btn btn-primary">Import</button>
			</div>
	</div>	
</div>

@section('modals')
	@include('admin.modals')
@stop

@section('js')
<script async src="/js/admin/fileuploader.js"></script>
@stop

@stop
