<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameQuestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_question', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('college_id');
			$table->integer('game_id');
			$table->text('game_question');
			$table->text('game_answer');
			$table->dateTime('question_date');
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
		Schema::drop('game_question');
	}

}
