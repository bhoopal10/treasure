<?php 
class UsersTableSeeder extends Seeder
{
	public function run()
	{
		$user= new user();
		$user->email='wbhoopal@ymail.com';
		$user->username='bhoopalw';
		$user->password=Hash::make('123');
		$user->Isactive='Y';
		$user->profilesId=0;
		$user->save();
	}
}