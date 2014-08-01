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

<div class="col-sm-12 col-md-12">
	<div id="no-more-tables">
	<table class="table">
		<thead>
			<tr>
				<th>Sno</th>
				<th>Participant Name</th>
				<th>Email</th>
				<th>Time(seconds)</th>
				<th>Status</th>
				<th>Details</th>
			</tr>
		</thead>
		<tbody>

		@if($score)
		<?php $i=1; ?>
		@foreach($score as $res)
			<tr>
				<td>{{$i++}}</td>
				<td>{{$res->displayName}}</td>
				<td>{{$res->email}}</td>
				<td>{{$res->time}}</td>
				<td><?php  if($res->answered){ echo "Qualified"; }else { echo 'Pending / Not qualified'; } ?></td>
				<td><a href="<?php echo URL::to('college/score/stat-detail').'/'.$res->userId ?>">View Details</a></td>
			</tr>
		@endforeach
		@endif
		</tbody>
	</table>
	</div>
</div>
</div>
@stop