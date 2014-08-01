<?php 
class ProfileTableSeeder extends Seeder
{
	public function run()
	{
		$profile=new Profile();
		$profile->profile_name='student';
		$profile->save();
	}
}