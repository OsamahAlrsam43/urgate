<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReadStateTable extends Migration {

	public function up()
	{
		Schema::create('read_state', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('message_id');
			$table->integer('user_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('read_state');
	}
}