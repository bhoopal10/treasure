@extends('college/layout.main')
@section('content')
<div class="col-sm-12 col-md-12">
@if(Session::has('success'))
<div class="alert alert-success">
	<span>{{Session::get('success')}}</span>
</div>
@elseif(Session::has('error'))
<div class="alert alert-danger">
	<span>{{Session::get('error')}}</span>
</div>
@endif
<hr>
@if($stat)
	<div class="col-sm-6 col-md-4">
		<div id="no-more-tables">
			<table class="table table-bordered">
				<tr>
					<td>Name</td>
					<td>{{$stat[0]->displayName}}</td>
				</tr>
				<tr>
					<td>Email</td>
					<td>{{$stat[0]->email}}</td>
				</tr>
				<tr>
					<td>Mobile</td>
					<td>{{$stat[0]->mobile}}</td>
				</tr>
				<tr>
					<td>Phone</td>
					<td>{{$stat[0]->phone}}</td>
				</tr>

			</table>
		</div>
	</div>
@endif
	<div class="col-sm-6 col-md-8">
		<div id="no-more-tables">
			<table class="table">
				<thead>
					<tr>
						<th>Sno</th>
						<th>Question</th>
						<th>Test Started</th>
						<th>Test Ended</th>
						<th>Answer</th>
						<th>Spend Time</th>

					</tr>
				</thead>
				<tbody>

				@if($stat)
				<?php $i=1; ?>
				@foreach($stat as $res)
					<tr>
						<td>{{$i++}}</td>
						<td>{{$res->game_question}}</td>
						<td>{{$res->start_time}}</td>
						<td>{{{ ($res->end_time !=0) ? $res->end_time:'NA'}}}</td>
						<td><?php  if($res->answered){ echo "Yes"; }else { echo 'No'; } ?></td>
						<td>{{{ ($res->spend_time)?$res->spend_time :'NA'}}}</td>
						
					</tr>
				@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>


@stop