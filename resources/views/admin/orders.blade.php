@extends('adminlte::page')


	@section('title', 'Orders')
	<style>
		.form-group, .no-padding{
			margin-bottom:0!important;
		} 
		.order-table{			
			text-align:center!important;
		}
		.order-table th{
			border:1px solid black!important;
			font-size: 14px!important;
			text-align: center;
			padding:6px 0;
		}
		.order-table td{
			border:1px solid black!important;
			font-size:14px!important;
			padding:6px 0;
		}
		#editservice i.fa-gbp{
			font-size: 12px!important;
			color: #424141;
		}
		.cancel{
			color:red;
			text-transform:capitalize;
		}
		.paid{
			color:green;
			text-transform:capitalize;
		}
		.pending{
			color:blue;
			text-transform:capitalize;
		}
		.note-para{
			display:inline-block!important;
		}
	</style>
	
	@section('content_header')
    <h1>Orders</h1>
	@stop

	@section('content')
	
		@csrf
		@if (Session::has('flash_message_success'))
	        <div class="alert alert-info alert-block" id="orders_flash_message">
	        <button type="button" class="close" data-dismiss="alert">×</button>
	        <strong>{!! session('flash_message_success')!!}</strong>
	        </div>
    	@endif
		<div class="form-group" style="width: 120px;">
		  <label for="sel1">Select status list:</label>
		  <select class="form-control" id="mystatus">
		  	@if($option == 'all')
		  	<option value="all" selected>All</option>
		    <option value="paid">Paid</option>
		    <option value="pending">Pending</option>
		    <option value="cancel">Cancel</option>
		    @elseif($option == 'paid')
		    <option value="all">All</option>
		    <option value="paid" selected>Paid</option>
		    <option value="pending">Pending</option>
		    <option value="cancel">Cancel</option>
		    @elseif($option == 'pending')
		    <option value="all">All</option>
		    <option value="paid">Paid</option>
		    <option value="pending" selected>Pending</option>
		    <option value="cancel">Cancel</option>
		    @else
		    <option value="all">All</option>
		    <option value="paid">Paid</option>
		    <option value="pending">Pending</option>
		    <option value="cancel" selected>Cancel</option>
		    @endif
		  </select>
		</div>

		
  
		<table class="table table-hover" id="order_details">

			<thead>

				 <th>S.No</th>

				 <th>Order No.</th>
					
				<th>Booking DateTime</th>
				
				 <th>Coach Name</th>
				  
				 <th>Total Amount ( <i class="fa fa-gbp"></i>)</th>

				 <th>Commission ( <i class="fa fa-gbp"></i>)</th>

				 <th>Coach Amount ( <i class="fa fa-gbp"></i>)</th>

				 <th>Status</th>
				  
				 <th>Action</th>

			</thead>

			<tbody>
				@php
				$i = 1;
				@endphp
			@foreach($orderviews as $data)

				<tr>

				  <td>{{$i++}} </td>

				  <td>{{$data['booking_no']}}  </td>
				  
				  <td>{{$data['booking_date']}}</td>

				  <td>{{$data['coachname']}} </td>
				  	
				  <td><i class="fa fa-gbp"></i> {{number_format($data['total_amount'], 2)}} </td>

				  <td><i class="fa fa-gbp"></i> {{ number_format($data['commission'], 2 )}}</td>

				  <td><i class="fa fa-gbp"></i> {{ number_format($data['paid_coach_amount'], 2)}}</td>

				  <td>{{$data['status']}}</td>

				  <!-- <td>{{$data['status']}}</td> -->

				  <td>
				  	<button class="btn btn-primary btn-sm edit_modal_" id="edit_modal_" data-id="{{ $data['booking_no'] }}" data-playerName="{{ $data['playerName'] }}" data-playerEmail="{{ $data['playerEmail'] }}" data-coachName="{{ $data['coachname'] }}" data-coachEmail="{{ $data['coachemail'] }}" data-booking_date="{{ $data['booking_date'] }}" data-amount="{{ $data['total_amount'] }}" data-status="{{ $data['status'] }}"  data-slot_bookingStart="{{ $data['slot_timing_start'] }}" data-slot_bookingEnd="{{ $data['slot_timing_end'] }}" data-note="{{ $data['note'] }}" data-toggle="modal" data-target="" title="view" ><i class='fa fa-eye'></i></button> 

				  	<button class="btn btn-success btn-sm edit_status_" id="edit_status_" data-id="{{ $data['booking_no'] }}" data-status="{{ $data['status'] }}" data-toggle="modal" data-target="#editstatus" title="edit" ><i class='fa fa-edit'></i></button> 
					
				</td>
				</tr>
				
		@endforeach

			</tbody>

		</table>

		<!-- Modal -->
		<div id="editservice" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title text-center"><b>Order details</b></h4>
			  </div>
			  
			  <div class="modal-body">
			  <input type="hidden" id="edit_order_id" name="orders_id">
				<div class="row"> 
					<div class="col-sm-6">
						<p><b>Player details</b></p>
						<div class="form-group row">
							<label for="name" class="col-xs-4 col-md-3 control-label">Name</label>
							<p id="edit_service_playerName" class="no-padding" name="playerName"></p>							
						</div>
						<div class="form-group row">
							<label for="name" class="col-xs-4 col-md-3 control-label">Email</label>
							<p id="edit_service_playerEmail" class="no-padding" name="playerEmail"></p>
						</div>
					</div>
					<div class="col-sm-6">
						<p><b>Coach details</b></p>
						<div class="form-group row">
							<label for="name" class="col-sm-4 col-md-3 control-label">Name</label>
							<p id="edit_service_coachname" class="no-padding" name="coachname"></p>
						</div>
						<div class="form-group row">
							<label for="name" class="col-sm-4 col-md-3 control-label">Email</label>
							<p id="edit_service_coachemail" class="no-padding" name="coachemail"></p>
						</div>
					</div>
				</div>
				
				 <!--<div class="form-group">
                    <label for="name" class="control-label">Note : </label>
					<p id="edit_service_note" class="note-para"></p>
                </div> -->
			  	
			  	<p><b>Order no.:&nbsp;&nbsp;</b>&nbsp;&nbsp;<span id="edit_service_order"></span>&nbsp;&nbsp;&nbsp;<span><b>Date:</b>22-07-2019</span></p>
                
				<table class="order-table table table-bordered">
					<!--<tr>
						<th>Sr. No.</th>
						<th>Booking Date</th>
						<th>Timeslot</th>
						<th>Price</th>
						<th>Payment Status</th>
					</tr> -->
					<!--<tr>
						<td>1.</td>
						<td id="edit_service_bookingDate" name="booking_date"></td>
						<td>10am - 11pm</td>
						<td><i class="fa fa-gbp"></i> <span id="edit_service_amount" name="amount"></span></td>
						<td id="edit_service_status" class="cancel" name="status"></td>
					</tr>
					<tr>
						<td>1.</td>
						<td id="edit_service_bookingDate" name="booking_date"></td>
						<td>10am - 11pm</td>
						<td><i class="fa fa-gbp"></i> <span id="edit_service_amount" name="amount"></span></td>
						<td class="paid">Paid</td>
					</tr>
					<tr>
						<td>1.</td>
						<td id="edit_service_bookingDate" name="booking_date"></td>
						<td>10am - 11pm</td>
						<td><i class="fa fa-gbp"></i> <span id="edit_service_amount" name="amount"></span></td>
						<td class="pending">Pending</td>
					</tr> -->
				</table>
                               
				<p id="add_custom"></p>		
				<!--<p class="text-right"><b>Subtotal : </b><i class="fa fa-gbp"></i>&nbsp;400</p>
				<p class="text-right"><b>Total : </b><i class="fa fa-gbp"></i>&nbsp;400</p>-->
				
			 </div>
			</div>

		  </div>

		 </div>
		  <!--status  Modal -->

		<div id="editstatus" class="modal fade" role="dialog">
		  <div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Order status</h4>
			  </div>
			  <form action="{{ url('/statusUpdate') }}" method="post">
			  	@csrf
			  <div class="modal-body">
			  	<input type="hidden" id="edit_status_id" name="status_id">
			  	
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Status</label>
                    <div class="col-sm-12">
                        <select class="form-control" id ="edit_order_status" name="status">
				
					    </select>
                    </div>
                </div>
                
			  <div class="modal-footer" style="display: flow-root;">
			  	<button type="submit" class="btn btn-info" id="status_edit_service">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			  </div>
			</form>
			 </div>
			</div>

		  </div>
	
	@stop
	
	@section('css')
		<link rel="stylesheet" href="/css/admin_custom.css">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	@stop
	
	@section('js')

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<script>
		
		$(document).ready( function () {
			$('#order_details').DataTable({
				"scrollX": true,
				"lengthMenu": [[25, 50, 75, -1], [25, 50, 75,"All"]] //datatable top left lenght 25 open
			});
		} );
		
		setTimeout( function(){ 
			$('#orders_flash_message').hide();
		  } , 2000 ); 
			
			
		$(".edit_modal_").on("click", function(){
			$("#edit_service_playerName").text($(this).attr('data-playerName'));
			$("#edit_service_playerEmail").text($(this).attr('data-playerEmail'));
			$("#edit_service_coachname").text($(this).attr('data-coachName'));
			$("#edit_service_coachemail").text($(this).attr('data-coachEmail'));
			$("#edit_service_bookingDate").text($(this).attr('data-booking_date'));
			$("#edit_service_amount").text($(this).attr('data-amount'));
			$("#edit_service_status").text($(this).attr('data-status'));
			$("#edit_service_coachId").text($(this).attr('data-coachId'));
			$("#edit_service_slotStart").text($(this).attr('data-slot_bookingStart'));
			$("#edit_service_slotEnd").text($(this).attr('data-slot_bookingEnd'));
			$("#edit_service_order").text($(this).attr('data-id'));
			//$("#edit_service_note").text($(this).attr('data-note'));
			var order_number = $(this).attr('data-id');
			$('.order-table').html('');
			$('#add_custom').html('');
			var CSRF_TOKEN = $('input[name="_token"]').val();
			$.ajax({
			  type: "POST",
			  url: "/getsuborders",
			  data: {_token: CSRF_TOKEN,order_number: order_number},
			  cache: false,
			  success: function(data){
				 console.log(data);
				 console.log(data.error);
				 $('.order-table').append('<tr><th>Sr. No.</th><th>Training Date</th><th>Timeslot</th><th>Price</th><th>Payment Status</th></tr>');
				 $('.order-table').append(data.html);
				 $('#add_custom').append(data.phtml);
				$('#editservice').modal('show');
			  }
			});
			
		});
		

		$(".edit_status_").on("click", function(){
			var status = $(this).attr('data-status');
			console.log($(this).attr('data-status'));
			if(status == 'paid')
			{
				$('#edit_order_status')
				.find('option')
				.remove();
				var option = "<option value='"+status+"'>paid</option>";
					option+= "<option value='cancel'>cancel</option>";
					option+= "<option value='pending'>pending</option>";
					$("#edit_order_status").append(option); 
			}
			else if(status == 'cancel')
			{
				$('#edit_order_status')
				.find('option')
				.remove();
				var option = "<option value='"+status+"'>cancel</option>";
					option+= "<option value='paid'>paid</option>";
					option+= "<option value='pending'>pending</option>";
					$("#edit_order_status").append(option); 
			}
			else
			{
				$('#edit_order_status')
				.find('option')
				.remove();
				var option = "<option value='"+status+"'>pending</option>";
					option+= "<option value='cancel'>cancel</option>";
					option+= "<option value='paid'>paid</option>";
				$("#edit_order_status").append(option); 
			}
			//$("#edit_order_status").val($(this).attr('data-status'));
			$("#edit_status_id").val($(this).attr('data-id'));
			$("#status_edit_service").attr('data-id',$(this).attr('data-id'));
		});


		$("#status_edit_service").on("click", function(){
			var CSRF_TOKEN = $('input[name="_token"]').val();

			var edit_service_coachname = $('#edit_status_id');

			var edit_status_id = $("#edit_status_id");
			
			if($("#edit_service_coachname").val() == ""){
				$.notify("Service field name cannot be empty.", "error");
				return;
			}
			
			$.ajax({
			  type: "POST",
			  url: "/statusUpdate",
			  data: {_token: CSRF_TOKEN, type:"update",edit_order_status:$("#edit_order_status").val(),edit_status_id:$("#edit_status_id").val()},
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

		$("#mystatus").change(function(){
			var value = $('#mystatus').val();
			if(value == 'all')
				window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/orders';
			else if(value == 'paid')
				window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/paid';
			else if(value == 'pending')
				window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/pending';
			else
				window.location.href = 'http://api.nextlevelfootballtraining.co.uk/admin/cancel';
		});
		
		</script>
	
	@stop
