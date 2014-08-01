<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('college', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',100);
			$table->string('admin_email',100);
			// $table->blob('landing_page');
			$table->string('url_slug',50);
			// $table->increments('id');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('college');
	}

}
