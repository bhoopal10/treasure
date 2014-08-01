<?php 
namespace App\Controllers\Admin;
class IndexController extends BaseController
{
	public function getIndex()
	{
		return \View::make('admin/index.index');
	}

	
}