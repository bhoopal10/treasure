<?php 
namespace App\Controllers\College;
class UserController extends ControllerBase
{
	public function getList()
	{
		return \View::make('College/user.list');
	}
}