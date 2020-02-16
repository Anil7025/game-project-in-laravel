@extends('adminlte::page')


	@section('title', 'Commission')
 
	
	@section('content_header')
    <h1>Master Table Settings</h1>
	@stop

	@section('content')
	
		@csrf
		@if (Session::has('flash_message_success'))
	        <div class="alert alert-info alert-block" id="commission_flash_message">
	        <strong>{!! session('flash_message_success')!!}</strong>
	        </div>
    	@endif
	

		<table class="display" cellspacing="0" width="100%" id="commission_details">

			<thead>

			  <th>ID</th>

			  <th>Option-key</th>

			  <th>Option-value</th>
			  
			  <th>Action</th>

			</thead>

			<tbody>

		@foreach($commissions as $data)

				<tr>

				  <td>{{$data->id}} </td>

				  <td>{{$data->option_key}} </td>

				  <td>{{$data->option_value}} </td>

				  <td>
				  	<button class="btn btn-primary btn-sm edit_modal_" id="edit_modal_" data-id="{{ $data->id }}" data-option_key="{{ $data->option_key }}" data-option_value="{{ $data->option_value }}" data-toggle="modal" data-target="#editCommission" ><i class="fa fa-fw fa-edit"></i> </button>
				</td>
				</tr>
				
		@endforeach

			</tbody>

		</table>

		<!-- Modal -->
		<div id="editCommission" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Commission service</h4>
			  </div>
			  <form action="{{ url('/commissionUpdate') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="edit_commission_id" name="commission_id">
			  	<div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Option_key</label>
                    <div class="col-sm-12">
                    	<div class="input-group-prepend">
                        <input type="text" readonly="readonly" class="form-control" id="edit_service_optionKey" name="option_key">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Option_value</label>
                    <div class="col-sm-12">
                    	<div class="input-group-prepend">
                        <input type="text" class="form-control" id="edit_service_optionValue" name="option_value" required="">
                    </div>
                </div>
			  <div class="modal-footer" style="display: flow-root;">
			  	<button type="submit" class="btn btn-info" id="commission_edit_service">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</form>
			 </div>
			</div>

		  </div>
		</div>
	
	

	@stop
	
	@section('css')
		<link rel="stylesheet" href="/css/admin_custom.css">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	

	@section('js')
	
	<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		
		$(document).ready( function () {
			 $('#commission_details').DataTable();
		} );

		setTimeout( function(){ 
			$('#commission_flash_message').hide();
		  } , 2000 ); 
		  
		$(".edit_modal_").on("click", function(){
			$("#edit_service_optionKey").val($(this).attr('data-option_key'));
			$("#edit_service_optionValue").val($(this).attr('data-option_value'));
			$("#edit_commission_id").val($(this).attr('data-id'));
			
		});
	
		
		</script>
	@stop