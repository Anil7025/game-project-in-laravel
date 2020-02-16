
	@extends('adminlte::page')
	
 
	@section('title', 'ADDCONTENT')
	
 
 
	@section('content_header')
	
    <h1>Add</h1>
	
	@stop
	
	

	@section('content')
	
		@csrf
		
		@if (Session::has('flash_message_success'))
	        <div class="alert alert-info alert-block">
	        	<button type="button" class="close" data-dismiss="alert">×</button>
	        <strong>{!! session('flash_message_success')!!}</strong>
	        </div>
    	@endif	
	
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

		<div class="container_data" style="display: flow-root; background: #ecf0f5; box-shadow: 2px 2px 9px 1px #dad8d8;">
			<h2 class="text-center">Add Content</h2>
			<div class="card col-md-12">
				<form action="{{ route('store_content')}}" method="POST">
					@csrf
					<div class="modal-body">
				  	<input type="hidden" id="addContent_id" name="addContent_id">
				  	<div class="form-group">
	                    <label for="name" class="col-sm-2 control-label">Title</label>
	                    <div class="col-sm-12">
	                        <input type="text" class="form-control" id="add_service_title" name="title" placeholder="Enter Title" required="">
	                    </div>
	                </div>
	                <div class="form-group">
	                    <label for="name" class="col-sm-2 control-label">Description</label>
	                    <div class="col-sm-12">
	                        <textarea class="form-control" type="text" name="description" rows="10" cols="100" placeholder="Enter Description"  required=""></textarea>
	                    </div>
	                </div>
	                <div class="form-group pull-right">
	                	<div class="col-sm-12">
	                		<button class="btn btn-success" value="submit" style="margin-top: 2%;">Save</button>
	                	</div>
	                </div>
				</form>
			</div>
		</div>
	
		
		
	@stop
	
	@section('css')
		<link rel="stylesheet" href="/css/admin_custom.css">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		
	@stop
	
	@section('js')
	
		<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
		<script>
		
			
		
		</script>
	
	@stop
