
	@extends('adminlte::page')
	
 
	@section('title', 'ALL_CONTENT')
	
 
 
	@section('content_header')
	
    <h1>All Content</h1>
	
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

		<table class="table table-hover" id="content_details">

			<thead>

			  <th>ID</th>

			  <th>Title</th>

			  <th>Description</th>

			  <th>Register date</th>

			  <th>Action</th>

			</thead>

			<tbody>

		@foreach($contents as $data)

				<tr id="contentid">

				  <td>{{$data->id}} </td>

				  <td>{{$data->title}} </td>

				  <td>{{$data->description}} </td>

				  <td>{{$data->created_at->format('d M Y')}} </td>

				  <td style="width:100px">
				  	<button class="btn btn-primary btn-sm edit_modal_" id="edit_modal_" data-id="{{ $data->id }}" data-title="{{ $data->title }}" data-description="{{ $data->description }}" data-toggle="modal" data-target="#content" ><i class="fa fa-fw fa-edit"></i> </button> /

					<input type="hidden" id="delete_content_id" required>
					<button class="btn btn-danger btn-sm" id="delete_modal_" data-id="{{ $data->id }}" ><i class="fa fa-fw fa-trash"></i></button> 
				  	 </td>

				</tr>
				
		@endforeach

			</tbody>

		</table>
		
		<!-- Modal -->
		<div id="content" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit player</h4>
			  </div>
			  <form action="{{ url('/contentUpdate') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="content_service_id" name="content_id">
			  	<div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" id="edit_service_title" name="title" placeholder="Enter Title" maxlength="50" required="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-12">
                        <textarea type="text" row="10" col="50" class="form-control" id="edit_service_description" name="description" required=""></textarea>
                    </div>
                </div>
			  <div class="modal-footer" style="display: flow-root;">
			  	<button type="submit" class="btn btn-info" id="content_edit_service">Update</button>
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
				$('#content_details').DataTable();
			} );

			$(".edit_modal_").on("click", function(){
				$("#edit_service_title").val($(this).attr('data-title'));
				$("#edit_service_description").val($(this).attr('data-description'));
				$("#content_service_id").val($(this).attr('data-id'));
				$("#content_edit_service").attr('data-id',$(this).attr('data-id'));
			});

			
			
			

			
			$("#content_edit_service").on("click", function(){
				var CSRF_TOKEN = $('input[name="_token"]').val();

				var edit_service_title = $('#edit_service_title');

				var content_service_id = $("#content_service_id");
				
				if($("#edit_service_title").val() == ""){
					$.notify("Service field name cannot be empty.", "error");
					return;
				}
				
				$.ajax({
				  type: "POST",
				  url: "/updateContent",
				  data: {_token: CSRF_TOKEN, type:"updateContent",edit_service_title:$("#edit_service_title").val(),edit_service_description:$("#edit_service_description").val(),content_service_id:$("#content_service_id").val()},
				  cache: false,
				  success: function(data){
					 console.log(data);
					 console.log(data.error);
					 
					 if(data.error !== undefined){
					 
						$.notify("Error adding service. "+data.error.message, "error");
					 }else{
						$.notify("Service Updated.", "success");
						location.reload();
						
					 }
					 
				  }
				});
				
			}); 




			
				$(document).on('click','#delete_modal_',function(){

					swal({
						  title: "Are you sure?",
						  text: "Once deleted, you will not be able to recover this SERVICE!",
						  icon: "warning",
						  buttons: true,
						  dangerMode: true,
						})
						.then((willDelete) => {
						  if (willDelete) 
						  {
                               
                               var CSRF_TOKEN = $('input[name="_token"]').val();

				               var delete_content_id = $(this).attr('data-id');
				
				// if($("#delete_service").val() == ""){
				// 	$.notify("Service field name cannot be empty.", "error");
				// 	return;
				// }
				
				$.ajax({
				  type: "POST",
				  url: "/deleteContent",
				  data: {_token: CSRF_TOKEN,delete_content_id:delete_content_id},
				  cache: false,
				  success: function(data){
					 console.log(data);
					 console.log(data.error);
					 
					 if(data.error !== undefined)
					 {
						$.notify("Error delete service. "+data.error.message, "error");
					 }
					 else
					 {
						$.notify("Service deleted.", "success");
						location.reload();
					 }
					 var contentid = data.content_id;
					 $('#contentid_'+contentid).hide();
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
