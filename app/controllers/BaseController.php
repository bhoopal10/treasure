<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
    
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
    public function getIndex()
    {
       
        return View::make('home');
       
    }
    public function getPpt()
    {
        return View::make('ppt');
    }
    public function getUpdateQuestion()
    {
    	$todayFrom=Date('Y-m-d 21:00:00');
		$todayTo=Date('Y-m-d 23:59:59');
		$todayNow=Date('Y-m-d H:i:s');
		$evFrom=Date('Y-m-d 20:00:00');
		$evTo=Date('Y-m-d 20:59:59');
		$evNow=Date('Y-m-d H:i:s');
		if($evFrom <= $evNow && $evTo >= $evNow)
		{
			$evaluation=DB::table('participant_stat')->where('answered','=',0)->get(array('participant_id'));
			if($evaluation)
			{
				foreach($evaluation as $value)
				{
					$Ids=$value->participant_id;
					DB::table('users')->where('id','=',$Ids)->update(array('userIsSuspended'=>'Y'));
				}
			}
		}
		elseif($todayFrom <= $todayNow && $todayTo >= $todayNow)
		{
			$fromday	= Date('Y-m-d 22:00:00');
			$today 		= Date('Y-m-d 20:00:00',strtotime('+1 day'));
			$sql 		= "select id,question_date from game_question where question_date between '$fromday' AND '$today'";
			$res 		=	DB::select($sql);
				if($res)
				{
					foreach($res as $value)
					{
						if(TodayQuestion::where('question_id', '=',$value->id )->count())
						{

						}
						else
						{
							$insert=array('question_id'=>$value->id,'question_date'=>$value->question_date);
							DB::table('today_question')->insert($insert);
						}
					}
				}
			// delete previous date questions in question update table
			// $Fdate 			= Date('Y-m-d 22:00:00',strtotime('-1 day'));
			$Tdate 			= Date('Y-m-d 20:00:00');
			echo $Tdate;
			$delete 		= DB::table('today_question')->where('question_date','<', $Tdate)->delete();
		}
		else
		{
			$Fdate 			= Date('Y-m-d 22:00:00',strtotime('-1 day'));
			$Tdate 			= Date('Y-m-d 20:00:00');
			$update 		= DB::table('game_question')->whereBetween('question_date',array($Fdate,$Tdate))->get();
				if($update)
				{
					foreach($update as $value)
					{
						if(TodayQuestion::where('question_id', '=',$value->id )->count())
						{

						}
						else
						{
							$insert=array('question_id'=>$value->id,'question_date'=>$value->question_date);
							DB::table('today_question')->insert($insert);
						}
						
					}
				}
			
		}
    }

}
