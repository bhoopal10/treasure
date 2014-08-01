<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantStatTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participant_stat', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('participant_id');
			$table->integer('question_id');
			$table->dateTime('stat_time');
			$table->dateTime('end_time');
			$table->integer('answered');
			$table->softDeletes();
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
		Schema::drop('participant_stat');
	}

}
