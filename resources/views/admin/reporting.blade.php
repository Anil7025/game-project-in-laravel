@extends('adminlte::page')


	@section('title', 'Reporting')
	
	@section('content_header')
    <h1>Media Details</h1>
	@stop

	@section('content')
	
		@csrf
		@if (Session::has('flash_message_success'))
	        <div class="alert alert-info alert-block">
	        <button type="button" class="close" data-dismiss="alert">×</button>
	        <strong>{!! session('flash_message_success')!!}</strong>
	        </div>
    	@endif
		<div class="form-group" style="width: 120px;">
		  <label for="sel1">Select status list:</label>
		  <select class="form-control" id="mystatus">
		  	@if($option == 'all')
		  		<option value="all" selected>All</option>
		  		<option value="publish">Publish</option>
		  		<option value="unpublish">Unpublish</option>
		  	@elseif($option == 'unpublish')
		  		<option value="all">All</option>
		  		<option value="publish">Publish</option>
		  		<option value="unpublish" selected>Unpublish</option>
		  		
		  	@else
			    <option value="all">All</option>
		  		<option value="publish" selected>Publish</option>
		  		<option value="unpublish">Unpublish</option>
		    @endif
		  </select>
		</div>
  
		<table class="table table-hover" id="media_details">

			<thead>

			  <th>S.No</th>

			  <th>Name</th>

			  <th>Email</th>

			  <th>Current Time</th>
			  
			  <th>image</th>

			  <th>video</th>

			  <th>Status</th>

			</thead>

			<tbody>
				@php
				$i = 1;
				@endphp
				@foreach($reporting_array as $data)

				<tr id="mediaid_{{$data['id']}}">

				  <td>{{$i++}}</td>

				  <td>{{ $data['fname'] }}</td>

				  <td>{{ $data['email'] }}</td>

				  <td>{{ $data['created_at'] }}</td>

				  @if($data['type'] == 'image')	
				  <td class="edit_modal_media_" id="edit_modal_media_" data-id="{{ $data['id'] }}" data-image="{{ $data['images'] }}" data-toggle="modal" data-target="#mediaImages"><img width="50px" height="50px" src="{{$data['images']}}" /></td>
				  @else
				  <td></td>
				  @endif

				  @if($data['type'] == 'video')	
				  <td class="edit_modal_video_" style="position: relative;" id="edit_modal_video_" data-id="{{ $data['id'] }}" data-video="{{ $data['images'] }}" data-toggle="modal" data-target="#mediavideos">
				     <video width="70" height="50">
				       <source src="{{$data['images']}}" allowfullscreen/>
				     </video>
				     <i class='fa fa-play-circle' style="position: absolute;z-index: 13;top: 67%;left: 53%; margin-left: -35px;margin-top: -27px;text-decoration: none;color: #f1022d;font-size: 26px;" ></i>
				   </td>
				  @else
				  <td></td>
				  @endif

				  @if($data['status'] == 1)
				  <td><button class="btn btn-success" id="button_{{$data['id']}}" value="like" onclick="changeButtonStatus({{$data['id']}},{{$data['status']}})"><i class="fa fa-thumbs-up"></i> publish</button></td>
				  @else
				  <td><button class="btn btn-danger" id="button_{{$data['id']}}" value="dislike" onclick="changeButtonStatus({{$data['id']}},{{$data['status']}})"><i class="fa fa-thumbs-down"></i> unpublish</button></td>
				  @endif

				</tr>
				
				@endforeach

			</tbody>

		</table>
		<!--images  Modal -->
		<div id="mediaImages" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  	<input type="hidden" id="edit_media_id" name="media_id">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="edit_service_name">Media Image</h4>
			  </div>
			  <div class="modal-body">
			  	<!--<video controls id="video1" style="width: 100%; height: auto; margin:0 auto; frameborder:0;">
		          <source id="edit_service_media" src="" >
		          Your browser doesn't support HTML5 video tag.
		        </video> -->
			  	<img id="edit_service_media" style="height: 400px;width: 572px" src="" >
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</form>
			 </div>
			</div>

		  </div>
		</div>

		<!--videos  Modal -->
		<div id="mediavideos" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
			  	<input type="hidden" id="edit_video_id" name="media_id">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="edit_service_name">Video</h4>
			  </div>
			  <div class="modal-body">
			  	
			  	<div class="embed-responsive embed-responsive-16by9">
				  <iframe class="embed-responsive-item" id="edit_video_media" controls src="" allowfullscreen></iframe>
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
		<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	@stop
	
	@section('js')

		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script>
		
			$(document).ready( function () {
				$('#media_details').DataTable({
					"lengthMenu": [[25, 50, 75, -1], [25, 50, 75,"All"]] //datatable top left lenght 25 open
				});
			} );


			// images js

			$(".edit_modal_media_").on("click", function(){
				console.log($(this).attr('data-image'));
				var image_length = $(this).attr('data-image').length;

				if(image_length > 0)
				{
					$("#edit_service_media").attr("src",$(this).attr('data-image'));
					$("#edit_media_id").val($(this).attr('data-id'));
				}
				else
				{	
					
					$("#edit_service_media").attr("src",'http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png');
				}
				
			});


			// videos js

			$(".edit_modal_video_").on("click", function(){
				console.log($(this).attr('data-video'));
				var image_length = $(this).attr('data-video').length;

				if(image_length > 0)
				{
					$("#edit_video_media").attr("src",$(this).attr('data-video'));
					$("#edit_video_id").val($(this).attr('data-id'));
				}
				else
				{	
					
					$("#edit_video_media").attr("src",'http://api.nextlevelfootballtraining.co.uk/storage/default180_180.png');
				}
				
			});


			function changeButtonStatus(id,status_val)
			{
				var text = $('#button_'+id).val();
				var CSRF_TOKEN = $('input[name="_token"]').val();

				$.ajax({
				  type: "POST",
				  url: "/reportingStatusUpdate",
				  data: {_token: CSRF_TOKEN, media_id: id,status_val: status_val},
				  cache: false,
				  success: function(data){
					 console.log(data);
					 console.log(data.status);
					 

					 if(data.status == undefined){
					 
						$.notify("Error adding service. "+data.status.message, "status");
					 }

					  if(data.status == 0)
						{
							$('#button_'+id).val('dislike');
							$('#button_'+id).html('<i class="fa fa-thumbs-down"></i> unpublish');
							$('#button_'+id).removeClass('btn-success');
							$('#button_'+id).addClass('btn-danger');
						}
						else
						{
							$('#button_'+id).val('like');
							$('#button_'+id).html('<i class="fa fa-thumbs-up"></i> publish');
							$('#button_'+id).removeClass('btn-danger');
							$('#button_'+id).addClass('btn-success');
						}

						// $.notify("Service Updated.", "success");
						// location.reload();


						
					 }
					 
				  
				});
				
			} 

			$("#mystatus").change(function(){
	        var value = $('#mystatus').val();
	        //alert(value);
	        if(value == 'all')
	         	window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/reporting';
	         else if(value == 'publish')
	         	window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/media_publish';
	         else
	         	window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/media_unpublish';
    		});
		
		</script>
	
	@stop
