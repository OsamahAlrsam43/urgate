<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateThreadsTable extends Migration {

	public function up()
	{
		Schema::create('threads', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('threads');
	}
}