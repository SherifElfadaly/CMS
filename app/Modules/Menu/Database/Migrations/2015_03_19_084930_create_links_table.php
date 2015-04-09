<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('links'))
		{
			Schema::create('links', function(Blueprint $table) {
				$table->increments('id');	
				$table->string('name');
				$table->string('href');
				$table->enum('target', ['_parent', '_blank', '_top', '_self']);
				$table->integer('display_order');
				$table->integer('parent_id');
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('links'))
		{
			Schema::drop('links');
		}
	}
}