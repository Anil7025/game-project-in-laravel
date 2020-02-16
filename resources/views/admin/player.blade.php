
	@extends('adminlte::page')
	
 
	@section('title', 'PLAYER')
	
 
 
	@section('content_header')
	
    <h1>Player</h1>
	
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

		<table class="table table-hover" id="player_details">

			<thead>

			  <th>S.No</th>

			  <th>Name</th>

			  <th>Email</th>

			  <th>Status</th>

			  <th>Action</th>

			</thead>

			<tbody>
			@php
			 $i = 1;
			@endphp
			@foreach($players as $data)

				<tr id="playerid_{{$data->id}}">

				 
				  <td>{{$i++}} </td>

				  <td>{{$data->fname}} </td>

				  <td>{{$data->email}} </td>

				  @if($data->deleted_at == null)

				  <td><button class="btn btn-success btn-sm" id="button_{{$data->id}}" value="like" onclick="changeStatus({{$data->id}})"><i class="fa fa-thumbs-up"></i> verify</button></td>
				  @else
				  <td><button class="btn btn-danger btn-sm" id="button_{{$data->id}}" value="dislike" onclick="changeStatus({{$data->id}})"><i class="fa fa-thumbs-down"></i> unverify</button></td>
				  @endif	

				  <td>
				  	<!--<button class="btn btn-primary btn-sm edit_modal_" id="edit_modal_" data-id="{{ $data->id }}" data-email="{{ $data->email }}" data-name="{{ $data->fname }}" data-role_id="{{ $data->role_id }}" data-status="{{ $data->status }}" data-toggle="modal" data-target="#editplayer" ><i class="fa fa-fw fa-edit"></i> </button> -->

					<input type="hidden" id="delete_player_id" required>
					<button class="btn btn-danger btn-sm" id="delete_modal_" data-id="{{ $data->id }}" ><i class="fa fa-fw fa-trash"></i></button> 
				  	 </td>

				</tr>		
			@endforeach

			</tbody>

		</table>
		
		<!-- Modal -->
		<div id="editplayer" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit player</h4>
			  </div>
			  <form action="{{ url('/updateUser') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="edit_service_id" name="player_id">
			  	<div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_service_input" name="fname" placeholder="Enter Name" maxlength="50" required="">
                    </div>
                </div>
			  	
			  <div class="modal-footer" style="display: flow-root;">
			  	<button type="submit" class="btn btn-info" id="player_edit_service">Update</button>
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
	@stop
	
	@section('js')
	
		<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
		<script>
		
			$(document).ready( function () {
				$('#player_details').DataTable({
					"lengthMenu": [[25, 50, 75, -1], [25, 50, 75,"All"]] //datatable top left lenght 25 open
				});
			} );

			$(".edit_modal_").on("click", function(){
				$("#edit_service_input").val($(this).attr('data-name'));
				$("#edit_service_email").val($(this).attr('data-email'));
				var role = $(this).attr('data-role_id');
				$("#edit_service_id").val($(this).attr('data-id'));
			});

			
			
			$(document).on('click','#delete_modal_',function(){

				swal({
					  title: "Are you sure?",
					  text: "Once deleted, you will not be able to recover this Player!",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) 
					  {
						   
						var CSRF_TOKEN = $('input[name="_token"]').val();

						var delete_player_id = $(this).attr('data-id');
				
				
						$.ajax({
						  type: "POST",
						  url: "/deleteUser",
						  data: {_token: CSRF_TOKEN,delete_service_id:delete_player_id},
						  cache: false,
						  success: function(data){
							 var playerid = data.user_id;
							 $('#playerid_'+playerid).hide();
							  if(data.error != "")
							  {
								$.notify("Error Occurs"+data.error.message, "error");
							  }  
							 
						  }
						});

						swal("User has been deleted!", {
							  icon: "success",
							});
						}
						else
						{
							swal("User is safe!");
						}
						    
			      });	
			}); 



			function changeStatus(id){
				var text = $('#button_'+id).val();
				var CSRF_TOKEN = $('input[name="_token"]').val();

				$.ajax({
				  type: "POST",
				  url: "/playerStatusUpdate",
				  data: {_token: CSRF_TOKEN, player_id: id},
				  cache: false,
				  success: function(data){
					 if(data.error !== undefined){
					 
						$.notify("Error adding service. "+data.error.message, "error");
					 }

					  if(data.status == 'success'){
					 	if(text == 'like')
						{
							$('#playerid_'+id).hide();
							$('#button_'+id).val('dislike');
							$('#button_'+id).html('<i class="fa fa-thumbs-down"></i> unverify');
							$('#button_'+id).removeClass('btn-success');
							$('#button_'+id).addClass('btn-danger');
						}
						else
						{
							$('#playerid_'+id).hide();
							$('#button_'+id).val('like');
							$('#button_'+id).html('<i class="fa fa-thumbs-up"></i> verify');
							$('#button_'+id).removeClass('btn-danger');
							$('#button_'+id).addClass('btn-success');
						}
					 }
					 
				  }
				});
				
			} 
		
		</script>
	
	@stop
