<?php 
namespace App\Controllers\Student;
class IndexController extends ControllerBase
{
	public function getIndex()
	{
		return \View::make('student/index.index');
	}
}