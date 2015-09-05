<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('stocks', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('stock_id');
            $table->string('body');
            $table->date('created_at');
            $table->string('symbol');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('stocks');
	}

}
