<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pages', function (Blueprint $table) {
			$table->id();
			$table->string('slug')->unique()->nullable();
			$table->string('name');
			$table->text('description')->nullable();
			$table->text('content')->nullable();
			// $table->tinyInteger('type')->unsigned();
			$table->string('image')->nullable();
			$table->string('thumbnail')->nullable();
			$table->nestedSet();
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
		Schema::dropIfExists('pages');
	}
}
