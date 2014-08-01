<?php
namespace App\Controllers\Admin;

class UserController extends ControllerBase 
{
	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return \View::make('admin/user.index');
		
	}

	public function getList()
	{
		$users=\User::where('profilesId','=',2)->paginate(3);
		return \View::make('admin/user.list')
						->with('users',$users);

				
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	public function getActivation($id)
	{
		if(is_numeric($id))
		{
			$user=\User::find($id);
			$user->isActive= ($user->isActive == 'Y') ? 'N' : 'Y';
			if($user->save())
			{
				return \Redirect::back()
						->with('success','Successfully updated');
			}
			else
			{
				return \Redirect::back()
						->with('error','Updation failed try again');
			}

		}
		else
		{
			\App::abort(404);
		}

	}
	public function getDelete($id)
	{
		if(is_numeric($id))
		{
			$cId=\DB::table('college')
						->where('user_id','=',$id)
						->first();
			if($cId)
			{
				$question=\DB::table('game_question')
						->where('college_id','=',$cId->id)
						->first();
				if(!$question)
				{
					$user=\DB::table('users')->where('id','=',$id);
					if($user->delete())
					{
						$college=\DB::table('college')->where('id','=',$cId->id)->delete();
						return \Redirect::back()
								->with('success','Successfully deleted');
					}
					else
					{
						return \Redirect::back()
								->with('error','Failed to delete try again later');
					}
				}
				else
				{
					return \Redirect::back()
								->with('error','This college has game question you cannot delete ');
				}
			}
			else
			{
				$user=\DB::table('users')->where('id','=',$id);
					if($user->delete())
					{
						return \Redirect::back()
								->with('success','Successfully deleted');
					}
					else
					{
						return \Redirect::back()
								->with('error','Failed to delete try again later');
					}
			}

		}
		else
		{
			\App::abort(404);
		}
	}


}
