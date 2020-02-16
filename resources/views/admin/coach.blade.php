
	@extends('adminlte::page')
	
 
	@section('title', 'COACH')
	
 	@section('content_header')
	
    <h1>Coach</h1>
	
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

		<table class="table table-hover" id="coach_details">

			<thead>

			  <th>S.No</th>

			  <th>Name</th>

			  <th>Email</th>

			  <th>Coach Image</th>

			  <th>Status</th>

			  <th>Action</th>

			</thead>

			<tbody>
			@php
			  $i = 1;
			@endphp
		@foreach($coachs as $data)

				<tr id="coachid_{{$data->id}}">

				  <td>{{$i++}} </td>
				 
				  <td>{{$data->fname}} </td>

				  <td>{{$data->email}} </td>
				  
				  @if($data->profile)
				  <td class="edit_modal_coach_" id="edit_modal_coach_" data-id="{{ $data->id }}" data-image="{{ url('').'/storage/'.$data->profile }}"  data-toggle="modal" data-target="#coachImages"><img width="40px" height="40px" src="{{url('').'/storage/'.$data->profile }}" /></td>
				  @else
				  <td class="edit_modal_coach_" id="edit_modal_coach_" data-id="{{ $data->id }}" data-image="{{ $data->profile }}"  data-toggle="modal" data-target="#coachImages"><img width="40px" height="40px" src="http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png" /></td>
				  @endif
				  
				 @if($data->deleted_at == null)
				  <td><button class="btn btn-success btn-sm" id="button_{{$data->id}}" value="like" onclick="changeStatus({{$data->id}})"><i class="fa fa-thumbs-up"></i> verify</button></td>
				  @else
				  <td><button class="btn btn-danger btn-sm" id="button_{{$data->id}}" value="dislike" onclick="changeStatus({{$data->id}})"><i class="fa fa-thumbs-down"></i> unverify</button></td>
				  @endif

				  <td>
				  	<!--<button class="btn btn-primary btn-sm edit_modal_" id="edit_modal_" data-id="{{ $data->id }}" data-email="{{ $data->email }}" data-name="{{ $data->fname }}" data-role_id="{{ $data->role_id }}" data-deleted="{{ $data->deleted_at }}" data-toggle="modal" data-target="#editcoach" ><i class="fa fa-fw fa-edit"></i> </button> -->


					<input type="hidden" id="delete_coach_id" required>
					<button class="btn btn-danger btn-sm" id="delete_modal_" data-id="{{ $data->id }}" ><i class="fa fa-fw fa-trash"></i></button> 
				  	 </td>

				</tr>
				
		@endforeach

			</tbody>

		</table>
		
		<!-- Modal Coach Edit -->
		<div id="editcoach" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Coach</h4>
			  </div>
			  <form action="{{ url('/updateCoach') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="edit_service_id" name="coach_id">
			  	<div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_service_input" name="fname" placeholder="Enter Name" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_service_email" name="email" placeholder="Enter Email" maxlength="100" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-12">
						<select class="form-control" id ="edit_service_role" name="role_id">
				
					    </select>
                    </div>
                </div>
			  <!--	<div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-12">
                        <select class="form-control" id ="edit_service_deleted" name="deleted_at">
				
					    </select>
                    </div>
                </div> -->
			  <div class="modal-footer" style="display: flow-root;">
			  	<button type="submit" class="btn btn-info" id="coach_edit_service">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</form>
			 </div>
			</div>

		  </div>
		</div>



		<!-- Modal -->
		<div id="coachImages" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  	<input type="hidden" id="edit_service_id" name="coach_id">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="edit_service_name">Coach Image</h4>
			  </div>
			  <div class="modal-body">
			  	<div class="modalImage">
			  		<img class="" id="edit_service_image" width="100%" height="400" src=""/>
			  	</div>
			  <div class="modal-footer">
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
				$('#coach_details').DataTable({
					"lengthMenu": [[25, 50, 75, -1], [25, 50, 75,"All"]] //datatable top left lenght 25 open
				});
			} );

			


			$(".edit_modal_coach_").on("click", function(){
				
				// if($("#edit_service_image")){
				// 	.attr("src",$(this).attr('data-image'));
				// 	alert('true');
				// }else{
				// 	.attr( "src", "http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png" );
				// 	// this.src ='http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png';
				// 	 alert('false');
				// 	}
				console.log($(this).attr('data-image'));
				var image_length = $(this).attr('data-image').length;

				if(image_length > 0)
				{
					// alert($(this).attr('data-image'));
					$("#edit_service_image").attr("src",$(this).attr('data-image'));
					// $("#edit_service_image").attr("src",'http://api.nextlevelfootballtraining.co.uk/storage/upload/profile/2/66142-1558704692.jpg');
					$("#edit_service_name").val($(this).attr('data-name'));
					$("#edit_service_id").val($(this).attr('data-id'));
				}
				else
				{
					$("#edit_service_image").attr("src",'http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png');
				}
				
			});
			
			

			


	$(document).on('click','#delete_modal_',function(){

		swal({
			  title: "Are you sure?",
			  text: "Once deleted, you will not be able to recover this data",
			  icon: "warning",
			  buttons: true,
			  dangerMode: true,
			})
			.then((willDelete) => {
			  if (willDelete) 
			  {
				   
				   var CSRF_TOKEN = $('input[name="_token"]').val();

				   var delete_coach_id = $(this).attr('data-id');
				  
					$.ajax({
					  type: "POST",
					  url: "/deleteUser",
					  data: {_token: CSRF_TOKEN,delete_service_id:delete_coach_id},
					  cache: false,
					  success: function(data){
						 var coachid = data.user_id;
						 $('#coachid_'+coachid).hide();

						 if(data.status != "")
						 {
							$.notify("Error Occurs "+data.status.message, "error");
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
				  url: "/coachStatusUpdate",
				  data: {_token: CSRF_TOKEN, coach_id: id},
				  cache: false,
				  success: function(data){
					 console.log(data);
					 console.log(data.error);
					 
					 if(data.error !== undefined){
					 
						$.notify("Error adding service. "+data.error.message, "error");
					 }

					  if(data.status == 'success'){
					 	if(text == 'like')
						{	$('#coachid_'+id).hide();
							$('#button_'+id).val('dislike');
							$('#button_'+id).html('<i class="fa fa-thumbs-down"></i> unverify');
							$('#button_'+id).removeClass('btn-success');
							$('#button_'+id).addClass('btn-danger');
						}
						else
						{	$('#coachid_'+id).hide();
							$('#button_'+id).val('like');
							$('#button_'+id).html('<i class="fa fa-thumbs-up"></i> verify ');
							$('#button_'+id).removeClass('btn-danger');
							$('#button_'+id).addClass('btn-success');
						}

						//$.notify("Service Updated.", "success");
						//location.reload();
						
					 }
					 
				  }
				});
				
			} 
			
				$(document).on('click','#delete_stripe_modal_',function(){

					swal({
						  title: "Are you sure?",
						  text: "Once deleted, you will not be able to recover this data",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) 
						  {
                               
                               var CSRF_TOKEN = $('input[name="_token"]').val();

				               var delete_stripe_id = $(this).attr('data-id');
				               var coach_id = $(this).attr('data-coach-id');
				              
								$.ajax({
								  type: "POST",
								  url: "/delete_stripe_data",
								  data: {_token: CSRF_TOKEN,delete_stripe_id:delete_stripe_id,coach_id:coach_id},
								  cache: false,
								  success: function(data){
									 console.log(data);
									 console.log(data.status);

									 var coach_dataId = data.coach_id;
									 $('#coachdata_id_'+coach_dataId).empty();


									 if(data.status !== undefined)
									 {
										$.notify("Error delete service. "+data.status.message, "error");
									 }
									 else
									 {
										$.notify("Service deleted.", "success");
										location.reload();
									 }
									 
									 
								  }
								});


							    swal("Poof! Your SERVICE has been deleted!", {
							      icon: "success",
							    });
							  }
							   else
							    {
							    swal("Your SERVICE is safe!");
							    }
				             });

				
				
			}); 

		
		</script>
	
	@stop
