<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCharterPriceTable extends Migration {

	public function up()
	{
		Schema::create('charter_price', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('charter_id');
			$table->enum('flight_class', array('Economy', 'Business'));
			$table->double('price');
			$table->enum('flight_type', array('OneWay', 'RoundTrip', 'OpenReturn'));
			$table->integer('open_duration');
		});
	}

	public function down()
	{
		Schema::drop('charter_price');
	}
}