
	@extends('adminlte::page')
	
 
	@section('title', 'payment')
	
 
 
	@section('content_header')
	
    <h1>Payment transaction</h1>
	
	@stop
	
	

	@section('content')
	
		@csrf
		
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<div id="exTab1" class="tabnav">	
<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#1a" data-toggle="tab">Monthly</a>
			</li>
			<li><a href="#2a" data-toggle="tab">Weekly</a>
			</li>
			<li><a href="#3a" data-toggle="tab">Today</a>
			</li>
  		
		</ul>

			<div class="tab-content clearfix">
			<div class="tab-pane active" id="1a">
			<table class="table table-hover" id="user_details">

				<thead>

				  <th>S.No</th>

				  <th>Month</th>

				  <th>Total Revenue</th>

				  <th>Total Commission</th>
				  
				  <th>Total Booking</th>


				</thead>

			  <tbody>
			  	@php 
			  	$i = 1;
			  	@endphp
			  	@foreach($monthlyTransaction as $data)
				<tr>
				 
				  <td>{{$i++}} </td>
				  @if($data->months == 1)
				  <td> January</td>
				  @elseif($data->months == 2)
				  <td> February </td>
				  @elseif($data->months == 3)
				  <td> March </td>
				  @elseif($data->months == 4)
				  <td> April </td>
				  @elseif($data->months == 5)
				  <td> May </td>
				  @elseif($data->months == 6)
				  <td> June </td>
				  @elseif($data->months == 7)
				  <td> 	July </td>
				  @elseif($data->months == 8)
				  <td> August </td>
				  @elseif($data->months == 9)
				  <td> September </td>
				  @elseif($data->months == 10)
				  <td> October  </td>
				  @elseif($data->months == 11)
				  <td> November </td>
				  @else
				  <td> December </td>
				  @endif
				  <td>{{$data->totalAmount}}</td>

				  <td>{{$data->totalCommission}}</td>

				  <td>{{$data->booking_date}}</td>

				</tr>

				@endforeach
				

			  </tbody>

			</table>

			</div>

			<div class="tab-pane" id="2a">
				<table class="table table-hover" id="user_details">

				<thead>

				  <th>S.No</th>

				  <th>Total Revenue</th>

				  <th>Total Commission</th>
				  
				  <th>Total Booking</th>

				</thead>

			  <tbody>
			  	@php 
			  	$i = 1;
			  	@endphp
			  	@foreach($weeklyTransaction as $data)
				<tr>
				 
				  <td>{{$i++}}</td>

				  <td>{{$data->totalAmount}}</td>

				  <td>{{$data->totalCommission}}</td>

				  <td>{{$data->totalBooking}}</td>

				</tr>
				@endforeach
			  </tbody>

			</table>
			</div>

        <div class="tab-pane" id="3a">
          <table class="table table-hover" id="user_details">

				<thead>

				  <th>S.No</th>

				  <th>ToDay </th>

				  <th>Total Revenue</th>

				  <th>Total Commission</th>
				  
				  <th>Total Booking</th>

				</thead>

			  <tbody>
			  	@php 
			  	$i = 1;
			  	@endphp
			  	@foreach($daysTransaction as $data)
				<tr>
				 
				  <td>{{$i++}}</td>
				  @if($data->days ==1)
				  <td>Sunday</td>
				  @elseif($data->days ==2)
				  <td>Monday</td>
				  @elseif($data->days ==3)
				  <td>Tuesday</td>
				  @elseif($data->days ==4)
				  <td>Wednesday</td>
				  @elseif($data->days ==5)
				  <td>Thursday</td>
				  @elseif($data->days ==6)
				  <td>Friday</td>
				  @elseif($data->days ==7)
				  <td>Saturday</td>
				  @endif
				  <td>{{$data->totalAmount}}</td>

				  <td>{{$data->totalCommission}}</td>

				  <td>{{$data->totalBooking}}</td>

				</tr>
				@endforeach
			  </tbody>

			</table>
		</div>

		</div>
  	 </div>







<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	@stop
	
	@section('css')
		<!-- <link rel="stylesheet" href="/css/admin_custom.css"> -->
		<link rel="stylesheet" href="/css/payment.css">
		<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	@stop
	
	@section('js')
	
		<script  href="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
		<script>
		
			$(document).ready( function () {
				$('#payment_details').DataTable();
			} );

			
		</script>
	
	@stop
