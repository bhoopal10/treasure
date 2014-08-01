<?php 
class DatabaseSeeder extends seeder
{
	public function run()
	{
		Eloquent::unguard();
		$this->call('UsersTableSeeder');
	}
}