<?php 
namespace App\Controllers\Student;
use \Illuminate\Database\MySqlConnection;
class TestController extends ControllerBase
{
	public function getStart()
	{
		return \View::make('student/test.start');
	}
	public function getTest()
	{
		
	}
	public function postQuestionSet()
	{
		// $type=\Input::get('type','text');
		$type='text';
		$from=Date('Y-m-d 22:00:00',strtotime('-1 day'));
		$to=Date('Y-m-d 20:00:00');

		/*-------------check current date between 8pm to 10pm------------------------------------*/
		$todayFrom=Date('Y-m-d 20:00:00');
		$todayTo=Date('Y-m-d 22:00:00');
		$todayNow=Date('Y-m-d H:i:s');
		if($todayFrom <= $todayNow && $todayTo >= $todayNow)
		{
			$data=array('noData'=>"<div class='alert alert-danger'>Today Session completed. Next round starts at 10p.m</div>");
			echo json_encode($data);
			return;
		}
		

		/*---------------End check current date between 8pm to 10pm--------------------------------*/
	
		$userId=\Auth::user()->id;
		\Session::put('developers.userId2',$userId);
		/* sql1 checks whether un answer question is avaliable in participant stat table*/
		$sqlone="select question_id,id,start_time,nos from participant_stat where participant_id = $userId AND start_time BETWEEN '$from' AND '$to' AND answered = 0";
		$sql1=\DB::select($sqlone);
		/* $sql2 checks whether ansewerd questions are available or not */
		$sqltwo="select question_id from participant_stat where participant_id = $userId AND start_time BETWEEN '$from' AND '$to' AND answered != 0";
		$sql2=\DB::select($sqltwo);
		$counts="select question_id from participant_stat where participant_id = $userId AND start_time BETWEEN '$from' AND '$to'";
		$counter=\DB::select($counts);
		\Session::put('developers.sql1',$sqlone);
		\Session::put('developers.sql2',$sqltwo);
		

		if($sql1)//Condition for un answer question
		{
			$id=$sql1[0]->question_id;
			$nos=count($counter);
			$sql="select id,game_question,game_option from game_question where  id = $id AND question_type='$type'";
			$question=\DB::select($sql);
			if($question)/* condition for unanswered question available in question table*/
			{
				$data=array('test'=>$question[0],'participant_id'=>$sql1[0]->id,'sTime'=>$sql1[0]->start_time,'nTime'=>Date('Y-m-d H:i:s'),'nos'=>$nos);
				echo json_encode($data);
				return;
			}
			else/* if not available then pick another random question */
			{
				// to delete un answered question from participant table
				\DB::table('participant_stat')->where('question_id', '=', $id)->delete();
				$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' AND q.question_type='$type' ORDER BY RAND() limit 0,1";
				$question=\DB::select($sql);
				if($question)
				{
					$sTime=Date('Y-m-d H:i:s');
					$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id,'start_time'=>$sTime));
					$data=array('test'=>$question[0],'participant_id'=>$participant,'sTime'=>$sTime,'nTime'=>Date('Y-m-d H:i:s'),'nos'=>1);
					echo json_encode($data);
					return;
				}
				else
				{
					$data=array('noData'=>"<div class='alert alert-danger'>Today Questions are not released</div>");
					echo json_encode($data);
					return;
				}
			}
		}
		else
		{
			if($sql2)
			{

				if(count($sql2) == 1)
				{
					$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' AND q.question_type = '$type' ORDER BY RAND() limit 0,1";
					$question=\DB::select($sql);
					if($question)
					{
						$sTime=Date('Y-m-d H:i:s');
						$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id,'start_time'=>$sTime));
						$data=array('test'=>$question[0],'participant_id'=>$participant,'sTime'=>$sTime,'nTime'=>Date('Y-m-d H:i:s'),'nos'=>2);
						echo json_encode($data);
						return;
					}
					else
					{
						$data=array('noData'=>"<div class='alert alert-danger'>Today Questions are not released</div>");
						echo json_encode($data);
						return;
					}
					
				}
				else
				{
					$data=array('success'=>'Congratulations you have completed all the questions for the day. Login  after 10 PM to see the next set of questions');
					echo json_encode($data);
					return;
				}
			}
			else
			{
				$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' AND q.question_type = '$type' ORDER BY RAND() limit 0,1";
				\Session::put('developers.sql3',$sql);
				$question=\DB::select($sql);
				if($question)
				{
					$sTime=Date('Y-m-d H:i:s');
					$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id,'start_time'=>$sTime));
					$data=array('test'=>$question[0],'participant_id'=>$participant,'sTime'=>$sTime,'nTime'=>Date('Y-m-d H:i:s'),'nos'=>1);
					echo json_encode($data);
					return;
				}
				else
				{
					$data=array('noData'=>"<div class='alert alert-danger'>Today Questions are not released</div>");
					echo json_encode($data);
					return;
				}
			}
		}
	}
	// public function postQuestionSet1()
	// {
	// 	$from=Date('Y-m-d 22:00:00',strtotime('-1 day'));
	// 	$to=Date('Y-m-d 20:00:00');
	// 	$userId=\Auth::user()->id;
	// 	/* sql1 checks whether un answer question is avaliable in participant stat table*/
	// 	$sql1="select question_id from participant_stat where participant_id = $userId AND created_at BETWEEN '$from' AND '$to' AND answered = 0";
	// 	$sql1=\DB::select($sql1);
	// 	/* $sql2 checks whether ansewerd questions are available or not */
	// 	$sql2="select question_id from participant_stat where participant_id = $userId AND created_at BETWEEN '$from' AND '$to' AND answered != 0";
	// 	$sql2=\DB::select($sql2);
	// 	if($sql1)//Condition for un answer question
	// 	{

	// 		$id=$sql1[0]->question_id;
	// 		$sql="select id,game_question,game_option from game_question where id = $id";
	// 		$question=\DB::select($sql);
	// 		if($question)/* condition for unanswered question available in question table*/
	// 		{
	// 			$data=array('test'=>$question[0],'participant_id'=>$sql1[0]->id,'nTime'=>Date('Y-m-d H:i:s'));
	// 			echo json_encode($data);
	// 			return;
	// 		}
	// 		else/* if not available then pick another random question */
	// 		{
	// 			// to delete un answered question from participant table
	// 			\DB::table('participant_stat')->where('question_id', '=', $id)->delete();
	// 			$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' ORDER BY RAND() limit 0,1";
	// 			$question=\DB::select($sql);
	// 			if($question)
	// 			{
	// 				$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id));
	// 				$data=array('test'=>$question[0],'participant_id'=>$participant);
	// 				echo json_encode($data);
	// 				return;
	// 			}
	// 			else
	// 			{
	// 				$data=array('noData'=>'No questions found');
	// 				echo json_encode($data);
	// 				return;
	// 			}
	// 		}
	// 	}
	// 	else
	// 	{
	// 		if($sql2)
	// 		{

	// 			if(count($sql2) == 1)
	// 			{
	// 				$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' ORDER BY RAND() limit 0,1";
	// 				$question=\DB::select($sql);
	// 				if($question)
	// 				{
	// 					$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id,'start_time'=>Date('Y-m-d H:i:s')));
	// 					$data=array('test'=>$question[0],'participant_id'=>$participant);
	// 					echo json_encode($data);
	// 					return;
	// 				}
	// 				else
	// 				{
	// 					$data=array('noData'=>'No questions found');
	// 					echo json_encode($data);
	// 					return;
	// 				}
					
	// 			}
	// 			else
	// 			{
	// 				$data=array('success'=>'Congratulation your Test is completed');
	// 				echo json_encode($data);
	// 				return;
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$sql="select  q.id,q.game_question,q.game_option  from game_question q where id not in (select question_id from participant_stat p where p.participant_id = $userId ) AND q.question_date BETWEEN '$from' AND '$to' ORDER BY RAND() limit 0,1";
	// 			$question=\DB::select($sql);
	// 			if($question)
	// 			{
	// 				$participant=\DB::table('participant_stat')->insertGetId(array('participant_id'=>$userId,'question_id'=>$question[0]->id,'start_time'=>Date('Y-m-d H:i:s')));
	// 				$data=array('test'=>$question[0],'participant_id'=>$participant);
	// 				echo json_encode($data);
	// 				return;
	// 			}
	// 			else
	// 			{
	// 				$data=array('noData'=>'No questions found');
	// 				echo json_encode($data);
	// 				return;
	// 			}
	// 		}
	// 	}
	// }
	public function postEvaluate()
	{
		/*-------------check current date between 8pm to 10pm------------------------------------*/
		$todayFrom=Date('Y-m-d 20:00:00');
		$todayTo=Date('Y-m-d 22:00:00');
		$todayNow=Date('Y-m-d H:i:s');
		if($todayFrom <= $todayNow && $todayTo >= $todayNow)
		{
			return 3;
		}
		
		/*---------------End check current date between 8pm to 10pm--------------------------------*/
		$option=\Input::get('answer-text','NOT');
		$option=mb_strtolower($option);
		if($option == 'NOT')
		{
			return 0;
		}
		else
		{
			$Qid=\Input::get('Qid');
			$pId=\Input::get('participant_id');
			$question=\GameQuestion::find($Qid)->toArray();
			$answer=$question['game_option'];
			$game_answer=$question['game_answer'];
			if($option == $answer)
			{
				$enddate=new \DateTime('now');
				$End=Date('Y-m-d H:i:s');
				$participant=\ParticipantStat::find($pId);
				if($participant)
				{
					$startTime=new \DateTime($participant->start_time);
					$interval=$startTime->diff($enddate);
					$days	 = $interval->format('%d');
					$hours   = $interval->format('%h'); 
					$minutes = $interval->format('%i');
					$seconds = $interval->format('%s');
					$spend_time=($days * 24 + $hours * 60 + $minutes * 60 + $seconds).',';
					$participant->spend_time=$spend_time;
					$participant->end_time=$End;
					$participant->answered=$game_answer;
					$participant->nos=1;
					$participant->save();
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				return 2;
			}
			
		}
	}
	// public function postEvaluate1()
	// {
	// 	$option=\Input::get('option','NOT');
	// 	if($option == 'NOT')
	// 	{
	// 		return 0;
	// 	}
	// 	else
	// 	{
	// 		$Qid=\Input::get('Qid');
	// 		$question=\GameQuestion::find($Qid)->toArray();
	// 		$answer=json_decode($question['game_answer']);
	// 		$Answ=$answer[$option];
	// 		if($Answ != 0)
	// 		{
	// 			$participant=\DB::table('participant_stat')->where('question_id','=',$Qid)->update(array('answered'=>$Answ,'end_time'=>Date('Y-m-d H:i:s')));
	// 			if($participant)
	// 			{
	// 				return 1;
	// 			}
	// 			else
	// 			{
	// 				return 2;
	// 			}
	// 		}
	// 		else
	// 		{
	// 			return 2;
	// 		}
			
	// 	}
	// }
}