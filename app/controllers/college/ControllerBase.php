<?php 
namespace App\Controllers\College;
class ControllerBase extends \Controller
{
	public function __construct()
	{
		// $this->beforeFilter('csrf', array('on' => 'post'));
	}
	public function getIndex()
	{
		return \Redirect::to('college/question/create-text');
	}
}
