
	@extends('adminlte::page')
	
 
	@section('title', 'REVIEW')
	
 
 
	@section('content_header')
	
    <h1>Review</h1>


	
	@stop
	
	

	@section('content')
	
	
		@csrf
		@if (Session::has('flash_message_success'))
	        <div class="alert alert-info alert-block">
	        	<button type="button" class="close" data-dismiss="alert">×</button>
	        <strong>{!! session('flash_message_success')!!}</strong>
	        </div>
    	@endif
	
	

		<div class="button">
			@if($button == 'all')
			<a href="{{route('all_review')}}" class="btn btn-success">All</a>
			<a href="{{route('review')}}" class="color btn">Pending</a>
			<a href="{{route('review_publish')}}" class="color btn">Publish</a>
			<a href="{{route('review_unpublish')}}" class="color btn">Unpublish</a>
			@elseif($button == 'pending')
			<a href="{{route('all_review')}}" class="color btn">All</a>
			<a href="{{route('review')}}" class="btn btn-success">Pending</a>
			<a href="{{route('review_publish')}}" class="color btn">Publish</a>
			<a href="{{route('review_unpublish')}}" class="color btn">Unpublish</a>
			@elseif($button == 'publish')
			<a href="{{route('all_review')}}" class="color btn">All</a>
			<a href="{{route('review')}}" class="color btn">Pending</a>
			<a href="{{route('review_publish')}}" class="btn btn-success">Publish</a>
			<a href="{{route('review_unpublish')}}" class="color btn">Unpublish</a>
			@else
			<a href="{{route('all_review')}}" class="color btn">All</a>
			<a href="{{route('review')}}" class="color btn">Pending</a>
			<a href="{{route('review_publish')}}" class="color btn">Publish</a>
			<a href="{{route('review_unpublish')}}" class="btn btn-success">Unpublish</a>
			@endif
		</div>
		<br/>
		<table class="table table-hover" id="player_details">

			<thead>

			  <th>S.No.</th>

			  <th>Coach Name</th>

			  <th>Player Name</th>

			  <th>Rating</th>

			  <th>Review</th>

			  <th>Status</th>

			  <th>Review date</th>

			  <th>Action</th>

			</thead>

			<tbody>
				@php
				$i =1;
				@endphp
		@foreach($arrayreviews as $data)

				<tr id="reviewid_{{$data['id']}}">

				  <td>{{$i++}} </td>

				  <td>{{$data['coachname']}} </td>

				  <td>{{$data['playername']}} </td>

				  <td>{{$data['rating']}} </td>

				  <td class="btn text-primary edit_modal_" id="edit_modal_" data-id="{{ $data['id'] }}" data-rating="{{ $data['rating'] }}" data-review="{{ $data['review'] }}" data-toggle="modal" data-target="#editreview" >{{$data['review']}} </td>

				  
				  @if($data['status']== 2)
				  <td>
				  	<input type="hidden" id="publish_review_id" required>
				  	<button class="btn btn-info edit_modal_" id="pending_modal_" value="like" data-id="{{ $data['id'] }}" > Pending</button></td>	
				  @elseif($data['status']== 1)
				  <td>
				  	<input type="hidden" id="publish_review_id" required>
				  	<button class="btn btn-success publish_modal_" id="publish_modal_" value="dislike" data-id="{{ $data['id'] }}"><i class="fa fa-thumbs-up"></i> publish</button></td>
				  @elseif($data['status']== 0)
				  <td>
				  	<input type="hidden" id="publish_review_id" required>
				  	<button class="btn btn-danger unpublish_modal_" id="unpublish_modal_" data-id="{{ $data['id'] }}" value="unlike"><i class="fa fa-thumbs-down"></i> unpublish</button></td>
				  	@else
				  <td>
				  	<input type="hidden" id="publish_review_id" required>
				  	<button class="btn btn-info edit_modal_" id="all_modal_" value="like" data-id="{{ $data['id'] }}" > All
				  	</button>
				  </td>
				  @endif


				  <td>{{$data['review_date']}} </td>

				  <td>

					<input type="hidden" id="delete_review_id" required>
					<button class="btn btn-danger btn-sm" id="delete_modal_" data-id="{{ $data['id'] }}" ><i class="fa fa-fw fa-trash"></i></button> 
				  	 </td>

				</tr>
				
		@endforeach

			</tbody>

		</table>
		
		<!-- Modal -->
		<div id="editreview" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Coach Reviews</h4>
			  </div>
			  <form action="{{ url('/reviewUpdate') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="review_service_id" name="review_id">
			  	<div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Rating</label>
                    <div class="col-sm-12 ">
                        <input type="hidden" id="edit_service_rating2" name="rating">
                        <div id="custom_rating">
                        </div>	
                        
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Review</label>
                    <div class="col-sm-12">
                    	<textarea type="text" rows="6" col="50" readonly="readonly" class="form-control" id="edit_service_review2" name="review" required=""></textarea>
                    </div>
                </div>
			  	
			  <div class="modal-footer" style="display: flow-root;">
			  	<!-- <button type="submit" class="btn btn-info" id="review_edit_service">Update</button> -->
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
		<link rel="stylesheet" https://cdn.jsdelivr.net/npm/sweetalert2@7.33.1/dist/sweetalert2.min.css>
	@stop
	
	@section('js')

		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
		<script>
		
			$(document).ready( function () {
				$('#player_details').DataTable({
					"lengthMenu": [[25, 50, 75, -1], [25, 50, 75,"All"]] //datatable top left lenght 25 open
				});
			} );

			$(".edit_modal_").on("click", function(){
				// $("#edit_service_coachId").val($(this).attr('data-coach_id'));
				// $("#edit_service_senderId").val($(this).attr('data-sender'));
				$("#edit_service_review2").val($(this).attr('data-review'));
				//$("#edit_service_rating").val($(this).attr('data-rating'));
				//alert($(this).attr('data-rating'));

				var star = $(this).attr('data-rating')

				if(star == 1)
				{
					$('#custom_rating').html('<i class="fa fa-star" data-rating="1"></i>');
				}
				else if(star == 2)
				{
					var rating = '<i class="fa fa-star" data-rating="1"></i><i class="fa fa-star" data-rating="2"></i>';
					$('#custom_rating').html(rating);
				}
				else if(star == 3)
				{
					var rating = '<i class="fa fa-star" data-rating="1"></i><i class="fa fa-star" data-rating="2"></i><i class="fa fa-star" data-rating="3"></i>';
					$('#custom_rating').html(rating);
				}
				else if(star == 4)
				{
					var rating = '<i class="fa fa-star" data-rating="1"></i><i class="fa fa-star" data-rating="2"></i><i class="fa fa-star" data-rating="3"></i><i class="fa fa-star" data-rating="4"></i>';
					$('#custom_rating').html(rating);
				}
				else
				{
					var rating = '<i class="fa fa-star" data-rating="1"></i><i class="fa fa-star" data-rating="2"></i><i class="fa fa-star" data-rating="3"></i><i class="fa fa-star" data-rating="4"></i><i class="fa fa-star" data-rating="5"></i>';
					$('#custom_rating').html(rating);
				}
							
				




				
				//$("#edit_service_status").val($(this).attr('data-status'));


				// var review = $(this).attr('data-status');

				// if(review == 1)
				// {
				// 	$('#edit_service_status')
				//     .find('option')
				//     .remove();
				// 	var option = "<option value='"+review+"'>activate</option>";
				// 		option+= "<option value='2'>deactivate</option>";
				// 	$("#edit_service_status").append(option); 
				// }else{
				// 	$('#edit_service_status')
				//     .find('option')
				//     .remove();
				// 	var option = "<option value='"+review+"'>deactivate</option>";
				// 		option+= "<option value='1'>activate</option>";
				// 	$("#edit_service_status").append(option);
				// }

				$("#review_service_id").val($(this).attr('data-id'));
				$("#review_edit_service").attr('data-id',$(this).attr('data-id'));
			});

			
			
			

			
			$("#review_edit_service").on("click", function(){

				var CSRF_TOKEN = $('input[name="_token"]').val();

				var edit_service_coachId = $('#edit_service_coachId');

				var review_service_id = $("#review_service_id");
				
				if($("#edit_service_coachId").val() == ""){
					$.notify("Service field name cannot be empty.", "error");
					return;
				}
				
				$.ajax({
				  type: "POST",
				  url: "/reviewUpdate",
				  data: {_token: CSRF_TOKEN, type:"updatePlayer",edit_service_coachId:$("#edit_service_coachId").val(),edit_service_senderId:$("#edit_service_senderId").val(),edit_service_rating:$("#edit_service_rating").val(),edit_service_review:$("#edit_service_review").val(),edit_service_status:$("#edit_service_status").val(),review_service_id:$("#review_service_id").val()},
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



			// pending publish and unpublish function

				$(document).on('click','#pending_modal_',function(id){
						
						//var text = $('#button_'+id).val();
						var publish_review_id = $(this).attr('data-id');
						var unpublish_review_id = $(this).attr('data-id');
						const swalWithBootstrapButtons = Swal.mixin({
							  customClass: {
							    confirmButton: 'btn btn-success',
							    cancelButton: 'btn btn-danger'
							  },
							  buttonsStyling: false,
							})

							swalWithBootstrapButtons.fire({
							  title: 'Are you sure?',
							  text: "Your function has been changed",
							  type: 'warning',
							  showCancelButton: true,
							  confirmButtonText: 'Publish',
							  cancelButtonText: 'Unpublish',
							  reverseButtons: true
							}).then((result) => {
							  if (result.value) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:1},
								  cache: false,
								 success: function(data) { 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide(); 
					             }         
								});

							    
							  } else if (
							    // Read more about handling dismissals
							    result.dismiss === Swal.DismissReason.cancel
							  ) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:0},
								  cache: false,
								 success: function(data) { 
					                console.log(status);
					 				console.log(status.error); 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide();
					             }         
								});
							  }
							});
						
				  	
				});


				//publish and unpublish function

				$(document).on('click','#publish_modal_',function(id){
						
						//var text = $('#button_'+id).val();
						var publish_review_id = $(this).attr('data-id');
						//var unpublish_review_id = $(this).attr('data-id');
						const swalWithBootstrapButtons = Swal.mixin({
							  customClass: {
							    confirmButton: 'btn btn-success',
							    cancelButton: 'btn btn-danger'
							  },
							  buttonsStyling: false,
							})

							swalWithBootstrapButtons.fire({
							  title: 'Are you sure?',
							  text: "Your function has been changed",
							  type: 'warning',
							  showCancelButton: true,
							  confirmButtonText: 'Pending',
							  cancelButtonText: 'Unpublish',
							  reverseButtons: true
							}).then((result) => {
							  if (result.value) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:2},
								  cache: false,
								 success: function(data) { 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide(); 
					             }         
								});

							    
							  } else if (
							    // Read more about handling dismissals
							    result.dismiss === Swal.DismissReason.cancel
							  ) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:0},
								  cache: false,
								 success: function(data) { 
					                console.log(status);
					 				console.log(status.error); 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide();
					             }         
								});
							  }
							});
						
				  	
				});

				//publish and unpublish function

				$(document).on('click','#unpublish_modal_',function(id){
						
						//var text = $('#button_'+id).val();
						var publish_review_id = $(this).attr('data-id');
						//var unpublish_review_id = $(this).attr('data-id');
						const swalWithBootstrapButtons = Swal.mixin({
							  customClass: {
							    confirmButton: 'btn btn-success',
							    cancelButton: 'btn btn-danger'
							  },
							  buttonsStyling: false,
							})

							swalWithBootstrapButtons.fire({
							  title: 'Are you sure?',
							  text: "Your function has been changed",
							  type: 'warning',
							  showCancelButton: true,
							  confirmButtonText: 'Pending',
							  cancelButtonText: 'Publish',
							  reverseButtons: true
							}).then((result) => {
							  if (result.value) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:2},
								  cache: false,
								 success: function(data) { 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide(); 
					             }         
								});

							    
							  } else if (
							    // Read more about handling dismissals
							    result.dismiss === Swal.DismissReason.cancel
							  ) {
							  	var CSRF_TOKEN = $('input[name="_token"]').val();
							  	$.ajax({
								  type: "POST",
								  url: "/admin/reviewpublishajax",
								  data: {_token: CSRF_TOKEN, publish_review_id:publish_review_id,status:1},
								  cache: false,
								 success: function(data) { 
					                console.log(status);
					 				console.log(status.error); 


					 				var reviewid = data.review_id;
					 				$('#reviewid_'+reviewid).hide();
					             }         
								});
							  }
							});
						
				  	
				});



			//delete function 
				$(document).on('click','#delete_modal_',function(){

				const swalWithBootstrapButtons = Swal.mixin({
					  customClass: {
					    confirmButton: 'btn btn-success',
					    cancelButton: 'btn btn-danger'
					  },
					  buttonsStyling: false,
					})

					swalWithBootstrapButtons.fire({
					  title: 'Are you sure?',
					  text: "You won't be able to revert this!",
					  type: 'warning',
					  showCancelButton: true,
					  confirmButtonText: 'Yes, delete it!',
					  cancelButtonText: 'No, cancel!',
					  reverseButtons: true
					}).then((result) => {
					  if (result.value) {

					  	var CSRF_TOKEN = $('input[name="_token"]').val();

				        var delete_review_id = $(this).attr('data-id');

				        $.ajax({
							  type: "POST",
							  url: "/destroyReview",
							  data: {_token: CSRF_TOKEN,delete_review_id:delete_review_id},
							  cache: false,
							  success: function(data){
								 console.log(status);
					 			 console.log(status.error);
								 var reviewid = data.review_id;
								 $('#reviewid_'+reviewid).hide();
								 if(data.status !== undefined)
								 {
									$.notify("Error delete service. "+data.status.message, "status");
								 }
								 else
								 {
									$.notify("Service deleted.", "success");
									location.reload();
								 }
								 
							  }
							});
					    swalWithBootstrapButtons.fire(
					      'Deleted!',
					      'Your data has been deleted.',
					      'success'
					    )
					  } else if (
					    // Read more about handling dismissals
					    result.dismiss === Swal.DismissReason.cancel
					  ) {
					    swalWithBootstrapButtons.fire(
					      'Cancelled',
					      'Your data is safe :)',
					      'error'
					    )
					  }
					});

				});
			


			function changeButtonStatus(id,status_val)
			{
				var text = $('#button_'+id).val();
				var CSRF_TOKEN = $('input[name="_token"]').val();

				$.ajax({
				  type: "POST",
				  url: "/statusReviewUpdate",
				  data: {_token: CSRF_TOKEN, review_id: id,status_val: status_val},
				  cache: false,
				  success: function(data){
					 console.log(data);
					 console.log(data.error);
					 
					 if(data.error !== undefined){
					 
						$.notify("Error adding service. "+data.error.message, "error");
					 }

					  if(data.status == 'success'){
					 	if(text == 'like')
						{
							$('#button_'+id).val('dislike');
							$('#button_'+id).html('<i class="fa fa-thumbs-up"></i> publish');
							$('#button_'+id).removeClass('btn-info');
							$('#button_'+id).addClass('btn-success');
						}
						else if(text == 'dislike')
						{
							$('#button_'+id).val('like');
							$('#button_'+id).html('<i class="fa fa-thumbs-down"></i> unpublish');
							$('#button_'+id).removeClass('btn-success');
							$('#button_'+id).addClass('btn-danger');
						}
						else
						{
							$('#button_'+id).val('unlike');
							$('#button_'+id).html('<i class="fa fa-thumbs-up"></i>pending');
							$('#button_'+id).removeClass('btn-success');
							$('#button_'+id).addClass('btn-info');
						}

						//$.notify("Service Updated.", "success");
						//location.reload();
						
					 }
					 
				  }
				});
				
			} 
			
			
		
		</script>
	
	@stop
