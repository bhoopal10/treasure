<?php 
namespace App\Controllers\Admin;
class ControllerBase extends \Controller
{
	public function __construct()
	{
		$this->beforeFilter('admin');
		
	}
	public function getIndex()
	{
		return \View::make('admin/index.index');
	}
	
}