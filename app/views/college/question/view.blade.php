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
<div id="no-more-tables">
	<table class="table">
		<thead>
			<tr>
				<th>Sno</th>
				<th>Question</th>
				<th>Starts From</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		<?php $i= $question->getFrom(); ?>
		@foreach($question as $Quest)
			<tr>
				<td><?php  echo $i; $i++; ?></td>
				<td>{{$Quest->game_question}}</td>
				<td><?php echo Date('d-m-Y h:i A',strtotime($Quest->question_date)); ?></td>
				<td>
				<div class="btn-group">
					<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
					    Action <span class="ace-icon fa fa-caret-down icon-on-right"></span>
					 </button>
					 <ul class="dropdown-menu" role="menu">
					 	<li><a href="<?php echo URL::to('college/question/delete/'.$Quest->id); ?>">Delete</a></li>
					 	<li><a href="<?php echo URL::to('college/question/edit/'.$Quest->id); ?>">Edit</a></li>
					 </ul>
				</div></td>
			</tr>
			@endforeach

		</tbody>
	</table>
	<?php echo $question->links(); ?>
</div>
</div>
@stop