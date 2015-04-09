<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('menus'))
		{
			Schema::create('menus', function(Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('description');
				$table->boolean('is_active')->default(0);
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
		if (Schema::hasTable('menus'))
		{
			Schema::drop('menus');
		}
	}
}