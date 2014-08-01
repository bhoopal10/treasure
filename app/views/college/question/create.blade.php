@extends('college/layout.main')
@section('content')
{{HTML::script('public/ckeditor/ckeditor.js')}}
<div class="col-sm-10 col-md-6">
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
	<form class="form-horizontal" action="<?php echo URL::to('college/question/create-multi'); ?>" method="post" id="multi-form" style="display:none">
		 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<input type="hidden" name="college_id" value="<?php echo 2; ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label">Date</label>
			<div class="col-sm-10">
				<input type="text" name="date" id="date" class="form-control" >
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Question</label>
			<div class="col-sm-10">
				<textarea class="form-control" name="question"></textarea>
			</div>
		</div>
		<hr>
		<!-- start Options -->
		<div class="form-group" >
			<label class="col-sm-2 control-label">options</label>
			<div class="col-sm-10">

				<div class="form-group">
					<label class="col-sm-1 control-form">1.</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" placeholder="Option" name="option[]">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" placeholder="marks" name="mark[]">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-form">2.</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" placeholder="Option" name="option[]">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" placeholder="marks" name="mark[]">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-form">3.</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" placeholder="Option" name="option[]">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" placeholder="marks" name="mark[]">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-1 control-form">4.</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" placeholder="Option" name="option[]">
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" placeholder="marks" name="mark[]">
					</div>
				</div>
				
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button class="btn btn-info btn-block">Create</button>
			</div>
		</div>
	</form>
	<!-- Text Answer Questions -->
	<form  class="form-horizontal" action="<?php echo URL::to('college/question/create-text'); ?>" method="post" style="display:none" id="text-form"  name="textForm">
		 <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		 <!-- TODO -->
		 <!-- for college id -->
		<input type="hidden" name="college_id" value="<?php echo 2; ?>">
		<div class="form-group">
			<label class="col-sm-2 control-label">Date</label>
			<div class="col-sm-10">
				<input required="required" type="text" name="date" id="date-text" class="form-control" >
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Question</label>
			<div class="col-sm-10">
				<!-- <textarea class="form-control" name="question"></textarea> -->
				<textarea required="required" name='question' id='editor1' class="editor1"></textarea>
			</div>
			
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Answer</label>
			<div class="col-sm-10">
				<input required="required" type="text" name="answer" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2">
				<button class="btn btn-primary btn-block" type="submit">Create</button>
			</div>
		</div>
	</form>

<?php $url=base_path(); ?>
@stop
@section('script')
{{HTML::script('public/js/jquery-ui-1.10.4.custom.min.js')}}
<script type="text/javascript">
	$('#date').datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
	});
	$('#date-text').datepicker({
		changeMonth:true,
		changeYear:true,
		dateFormat:'dd/mm/yy'
	});
	$(function(){
		var type="<?php echo $type; ?>";
		$('#'+type).show();
	});
	CKEDITOR.replace('editor1',{
	filebrowserBrowseUrl: "/public/ckfinder/ckfinder.html?type=Images",
    filebrowserUploadUrl: "<?php echo URL::to('college/question/upload-image') ?>"
	});
	
</script>

@stop
@section('css')
{{HTML::style('public/css/jquery-ui-1.10.4.custom.min.css')}}
@stop