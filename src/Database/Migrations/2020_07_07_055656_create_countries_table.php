<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(config('world.migrations.countries.table_name'), function (Blueprint $table) {
			$table->id();
			$table->string('iso2', 2);
			$table->string('name');
			$table->tinyInteger('status')->default(1);

			foreach (config('world.migrations.countries.optional_fields') as $field => $value) {
				if ($value['required']) {
					$table->string($field, $value['length'] ?? null)->nullable();
				}
			}
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists(config('world.migrations.countries.table_name'));
	}
}
