<?php 
namespace App\Controllers\College;
class ScoreController extends ControllerBase
{
	public function getView()
	{
		$from=Date('Y-m-d 22:00:00',strtotime('-1 day'));
		$to=Date('Y-m-d 20:00:00');

		// $sql="select p.id as statID, p.participant_id as userId, u.displayName,u.email,sum(p.spend_time) as time, 
		// 		min(answered) as answered, count(p.participant_id) as nos from users u JOIN participant_stat p on u.id=p.participant_id 
		// 		where p.start_time NOT BETWEEN '$from' AND '$to' GROUP BY p.participant_id ORDER BY sum(p.spend_time)";

	$sql="select p.id as statID, p.participant_id as userId, u.displayName,u.email,sum(p.spend_time) as time, 
				min(answered) as answered, count(p.participant_id) as nos from users u JOIN participant_stat p on u.id=p.participant_id 
				GROUP BY p.participant_id ORDER BY sum(p.spend_time)";

		$result=\DB::select($sql);
		
		return \View::make('college/score.view')
						->with('score',$result);
	}
	public function getStatDetail($id)
	{
		$sql="select u.id as userId,
					q.game_question,
					q.question_date,
					p.start_time,
					p.end_time,
					p.answered,
					p.spend_time,
					u.displayName,
					u.email,
					c.mobile,
					c.phone

		 from participant_stat p JOIN game_question as q on p.question_id = q.id JOIN users u on p.participant_id=u.id JOIN contact c on c.user_id = u.id where p.participant_id= $id";
		$result=\DB::select($sql);
		return \View::make('college/score.stat_detail')
						->with('stat',$result);
	}
} 