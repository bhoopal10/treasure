@extends('student/layout.main')
@section('content')

<div class="col-sm-12 col-md-12" style="padding-top:20px">
	<div class="col-sm-3 col-md-3">
		<div class="fc-widget-content" style="border:1px solid black">
			
		
		<div class="widget-header" style="background:none repeat scroll 0% 0% #EE533B !important;color:white!important;">
			Question Status
		</div>
		<div class="widget-body">
			<div class="wizard-steps">

				<div class="col-sm-6 col-md-6">
					Question started
				</div>
				<div class="col-sm-6 col-md-6">
				<div class="" id="spendTime"></div>
					
				</div>
			</div>
			<hr>
			<div class="wizard-steps">
				<div class="col-sm-6 col-md-6">
					Spending Time (sec)
				</div>
				<div class="col-sm-6 col-md-6">
					<b><span class="red" id='ShowTime'></span></b>
				</div>
			</div>
			
		</div>
		</div>
	</div>
	<div class="col-sm-6 col-md-8">
		<div class="col-sm-9" style="" id="wrongAnswer">
			
		</div>
		<div class="success col-sm-9" >
			<!-- <span> Congratulations you have completed all the questions for the day. Login  after 10 PM to see the next set of questions</span> -->
		</div>
		<div class="error col-sm-9" >
			<!-- <span>Today Questions are not released</span> -->
		</div>
		

		<form id="form1" method="post" onsubmit="return false" name="form1">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		
		 <div id="test-container" style="">

		 </div>
<div class="divider">&nbsp;</div>
		 <div id="answer" style="">
		 	
		 </div>
		    <div id="total">

		    </div>
			
		        <div style="display: none"  id="next">&nbsp;
				
		        <span class="col-sm-offset-2 col-sm-3 btn btn-primary" style="float: left;cursor: pointer;border-color: #F16439!important; background-color:#F16439!important;" ><b>Next</b></span>
				
		    </div>
		    <legend style="display: none"  id="finish">&nbsp;
		        <span class=" col-sm-3 btn btn-success" style="float: right;cursor: pointer;" >Finish</span>
		    </legend>
		</form>
	</div>
	<div class="col-sm-3 col-md-2">
		
	</div>
</div> 
	
@stop
@section('script')
<script type="text/javascript">
var x;
	$(document).ready(function(){
		var token="<?php echo csrf_token(); ?>";
		$.post("<?php echo URL::to('student/test/questions') ?>",{_token:token,type:"text"})
			.success(function(data){
				 var datas=$.parseJSON(data);
				 console.log(datas)
				 if(datas.test)
				 {
					var test             =datas.test;
					var participantId    =datas.participant_id;
					var nos              =datas.nos;
					var sTime            =datas.sTime;
					var nTime            =datas.nTime;
					var matchDate        = /(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/;
					var firstDateParsed  = matchDate.exec(sTime);
					var secondDateParsed = matchDate.exec(nTime);
					// var secondDateParsed = matchDate.exec();
					var a                        = new Date(firstDateParsed[1], firstDateParsed[2], firstDateParsed[3], firstDateParsed[4], firstDateParsed[5], firstDateParsed[6], 0);
					var b                        = new Date(secondDateParsed[1], secondDateParsed[2], secondDateParsed[3], secondDateParsed[4], secondDateParsed[5], secondDateParsed[6], 0);
					var differenceInMilliseconds = b.getTime() - a.getTime();
					var diff                     =differenceInMilliseconds / 1000 ;
					var diffMin                  =differenceInMilliseconds / 1000 / 60;
					var diffHours                =differenceInMilliseconds / 1000 / 60 / 60;
					var ShowTime                 =$('#ShowTime');
					var d                        =setInterval(function() { ShowTime.text(diff += 1);}, 1000);
					// setInterval(function() { $('#ShowTimeMin').text(Math.floor(diffMin));}, 1000);
					// setInterval(function() { $('#ShowTimeHours').text(Math.floor(diffHours));}, 1000);
					var tag="";
					var num="";
					var globalvar="";
					var key=0;
						globalvar=key;
						var color=(key%2 == 0)?"#F5F5F5":"";
						
						var options=test.game_option;
						// console.log(options);
						/* Question div*/
						$('#spendTime').append("<span><b> "+sTime+"  </b></span>")
						$('#test-container').append("<div class='col-sm-9 col-md-9 pull-left'><b>Q."+nos+"</b></div><div class='col-sm-9 col-lg-9' style='border:1px solid black;background: "+color+"'> <div class='questions col-sm-11 col-md-11 col-lg-11' id='ques"+key + "'>"
							+ '<p>'
							+ test.game_question
							+ "</p></div></div>");
							
						/*End question div*/
						/*Input for answer*/
							var container='ques'+key;
							$("#answer").append("<div class='col-sm-9 col-lg-9'>&nbsp;</div><div class='options'>"
								+'<p><input style="border:1px solid black" class="option col-sm-9" type="text" placeholder="Enter Answer" name="answer-text" id="answer-text"> </p>'
								+"</div><div class='col-sm-12'>&nbsp;</div>");
						/*End input for answer*/

						/*Option div*/
						// $.each(options,function(key1,value1){
						// 	var container='ques'+key;
						// 	$("#"+container).append("<div class='options'>"
						// 		+'<p><input class="option" type="radio" value="'
						// 		+key1
						// 		+'" name="option'
						// 		+'" id="opt'
						// 		+key+key1
						// 		+'" >'
						// 		+'<label for="opt'
						// 		+key+key1
						// 		+'">'
						// 		+ value1
						// 		+ '</label>'
						// 		+'</p>'
						// 		+"</div>");
						// });
						$("#total").html('<input id="total1" type="hidden" name="Qid" value="'+test.id+'" ><input type="hidden" name="participant_id" value="'+participantId+'">');

						/*End option div*/

					
					$('#next').show();
				}
				 else if(datas.msg)
				 {
					$('.error').append(datas.msg);
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
					alert('Must answer in text field');
				}
				else if(data == 1)
				{
					window.location="<?php echo URL::to('student/test/start'); ?>";
				}
				else if(data == 2)
				{

					$('#wrongAnswer').html("<div class='alert alert-danger'><span>Your answer is wrong. Please try again.</span></div>");
					$(".alert").fadeTo(3000,0).slideUp(1000,function(){

					} );
				}
				else
				{
					$('#wrongAnswer').html("<div class='alert alert-danger'><span>Time Out you can't answer now</span></div>");
				}
			});
		
	});
 
</script>
	
@stop