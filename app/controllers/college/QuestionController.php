<?php 
namespace App\Controllers\College;

class QuestionController extends ControllerBase
{
	public function getCreateMulti()
	{
		return \View::make('college/question.create')
						->with('type','multi-form');
	}
	public function postCreateMulti()
	{
		$question=\Input::get('question');
		if($question=='')
		{
			$collegeId=\Input::get('college_id');
			$options=\Input::get('option');
			$marks=\Input::get('mark');
			$date=\Input::get('date',Date('d/m/d'));
			$date=implode('-',array_reverse(explode('/',$date))).' 22:00:00';
			$option=[];
			foreach ($options as $key=>$value) {
				$option[$key]=$value;
			}
			$mark=[];
			foreach ($marks as $key => $value) {
				$mark[$key]=(is_numeric($value))?$value:0;
			}
			$Gquestion=new \GameQuestion();
				$Gquestion->college_id=$collegeId;
				$Gquestion->game_question=$question;
				$Gquestion->game_option=json_encode($option);
				$Gquestion->game_answer=json_encode($mark);
				$Gquestion->question_date=$date;
				$Gquestion->question_type='multi';
				$Gquestion->updated_at=Date('Y-m-d H:i:s');
			if($Gquestion->save())
			{
				return \Redirect::back()
						->with('success','Your question has been added');
			}
			else
			{
				return \Redirect::back()
						->with('error','your question failed to add');
			}
		}
		else
			{
				return \Redirect::back()
						->with('error','Please give question');
			}
		

	}
	public function getCreateText()
	{
		return \View::make('college/question.create')
						->with('type','text-form');
	}
	public function postCreateText()
	{
		$question=\Input::get('question');
		$date=\Input::get('date');
		$answer=\Input::get('answer');
		// echo $question;exit;
		if(!$question || !$date || !$answer)
		{
			return \Redirect::back()
					->with('error','Please fill all fields');
		}
		$collegeId=\Input::get('college_id');
		$answer=\Input::get('answer');
		$date=\Input::get('date',Date('d/m/d'));
		$date=implode('-',array_reverse(explode('/',$date))).' 22:00:00';
		$Gquestion=new \GameQuestion();
		$Gquestion->college_id=$collegeId;
		$Gquestion->game_question=$question;
		$Gquestion->game_option=mb_strtolower($answer);
		//TODO
		//game answer default 1
		$Gquestion->game_answer=1;
		$Gquestion->question_date=$date;
		$Gquestion->question_type='text';
		$Gquestion->updated_at=Date('Y-m-d H:i:s');
		if($Gquestion->save())
		{
			return \Redirect::back()
					->with('success','Your question has been added');
		}
		else
		{
			return \Redirect::back()
					->with('error','your question failed to add');
		}
	}
	public function getView()
	{
		//TODO
		//college id changeing
		$question=\GameQuestion::where('college_id','=',2)->paginate(10);
		return \View::make('college/question.view')->with('question',$question);
	}
	public function getDelete($id)
	{
		$check=\DB::table('participant_stat')
					->where('question_id','=',$id)
					->where('answered','=','0')
					->get();
		if($check)
		{
			return \Redirect::back()->with('error','This question is in use you con\'t delete');
		}
		else
		{
			$question = \GameQuestion::find($id);
			if($question->delete())
			{
				return \Redirect::back()->with('success','Your selected Question has been deleted');
			}
			else
			{
				return \Redirect::back()->with('error','Deletion failed try again later');
			}
		}
		

	}
	public function postUpdate()
	{

	}
	public function postUploadImage()
	{
		// $file=\Input::file('upload');
		$ext=\Input::file('upload')->getClientOriginalExtension();
		$fileName=Date('ymis').'.'.$ext;
		$path=base_path().'/public/img/upload/';
	
		if(\Input::hasFile('upload'))
		{
			\Input::file('upload')->move($path,$fileName);
		}
		else
		{
			echo 'error';
		}
	}
	public function getUploadImage() 
	{
	
	}
}
