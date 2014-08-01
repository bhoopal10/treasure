<?php 
namespace App\Controllers\Student;
class ControllerBase extends \Controller
{
	public function __construct()
	{
		$this->beforeFilter('csrf',array('on'=>'post'));
	}
	
}