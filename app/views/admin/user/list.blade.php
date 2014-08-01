@extends('admin/layout.main')
@section('content')
<table class="table table-dashed">
	<thead>
		<tr>
			<th>Sno</th>
			<th>College</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	@foreach($users as $user)
		<tr>
			<td>{{$user->userName}}</td>
			<td>{{$user->email}}</td>
			<td>
				@if($user->IsActive == 'Y')
				<span class="label label-success">Active</span>
				@else
				<span class="label label-danger">Not Active</span>
				@endif
			</td>
			<td>
				<div class="btn-group">
					<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
					    Action <span class="caret"></span>
					 </button>
					 <ul class="dropdown-menu" role="menu">
					 	@if($user->IsActive == 'Y')
					 	<li><a href="<?php echo URL::to('admin/user/activation/'.$user->id); ?>">Deactivate</a></li>
					 	@else
					 	<li><a href="<?php echo URL::to('admin/user/activation/'.$user->id); ?>">Activate</a></li>
					 	@endif
					 	<li><a href="<?php echo URL::to('admin/user/delete/'.$user->id) ?>" onclick="return confirm('Really you want to delete?')">Delete</a></li>
					 	<li><a href="#">Edit</a></li>
					 </ul>
				</div>
			</td>

		</tr>
		@endforeach
	</tbody>
</table>

<?php echo $users->links() ?>
@stop
