@extends('student/layout.main')
@section('content')
<div class="col-sm-12 col-md-12" >
	<div class="success alert alert-success" style="display:none">
		<span>Congratulation you completed test</span>
	</div>
	<div class="error alert alert-error" style="display:none">
		<span>Question is not found</span>
	</div>
	<div class="" style="" id="wrongAnswer">
		
	</div>
	<form id="form1" method="post" onsubmit="return validation()" name="form1">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<div class="divider">&nbsp;</div>
	 <div id="test-container" style="">

	 </div>

	    <div id="total">

	    </div>
		
	        <div style="display: none"  id="next">&nbsp;
			
	        <span class="col-sm-3 btn btn-primary" style="float: right;cursor: pointer;" >next</span>
			
	    </div>
	    <legend style="display: none"  id="finish">&nbsp;
	        <span class=" col-sm-3 btn btn-success" style="float: right;cursor: pointer;" >Finish</span>
	    </legend>
	</form>
</div> 
	
@stop
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		var token="<?php echo csrf_token(); ?>";
		$.post("<?php echo URL::to('student/test/question-set') ?>",{_token:token})
			.success(function(data){
				 var datas=$.parseJSON(data);
				 console.log(datas)
				 if(datas.test)
				 {
					var test=datas.test;
					var tag="";
					var num="";
					var globalvar="";
					var key=0;
						globalvar=key;
						var color=(key%2 == 0)?"#F5F5F5":"";
						
						var options=$.parseJSON(test.game_option);
						// console.log(options);
						/* Question div*/
						$('#test-container').append("<div class='col-sm-12 col-lg-12' style='border:1px dashed;background: "+color+"'><div class='col-sm-1 col-md-1 col-lg-1' >Q</div> <div class='questions col-sm-11 col-md-11 col-lg-11' id='ques"+key + "'>"
							+ '<p>'
							+ test.game_question
							+ "</p></div></div>");
							
						/*End question div*/
						/*Option div*/
						$.each(options,function(key1,value1){
							var container='ques'+key;
							$("#"+container).append("<div class='options'>"
								+'<p><input class="option" type="radio" value="'
								+key1
								+'" name="option'
								+'" id="opt'
								+key+key1
								+'" >'
								+'<label for="opt'
								+key+key1
								+'">'
								+ value1
								+ '</label>'
								+'</p>'
								+"</div>");
						});
						$("#total").html('<input id="total1" type="hidden" name="Qid" value="'+test.id+'" >');

						/*End option div*/

					
					$('#next').show();
				}
				 else if(datas.noData)
				 {
					$('.error').show();
					return false;
				 }
				 else if(datas.success)
				 {
					$('.success').show();
					return false;
				 }
				
			});
	});
	$('#next').on('click',function(){
		var opt=$('#form1').serializeArray();
		$.post("<?php echo URL::to('student/test/evaluate') ?>",opt)
			.success(function(data){
				if(data == 0)
				{
					alert('Please select any option');
				}
				else if(data == 1)
				{
					window.location="<?php echo URL::to('student/test/start'); ?>";
				}
				else if(data == 2)
				{

					$('#wrongAnswer').html("<div class='alert alert-danger'><span>You selected wrong answer</span></div>");

				}
			});
		
	});
	
</script>
@stop