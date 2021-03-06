<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('name');
			$table->text('details');
			$table->text('address');
			$table->text('type');
			$table->integer('institute_funding')->default('0'); // TO be filled after the event has ended
			$table->integer('sponsor_funding')->default('0'); // TO be filled after the event has ended
			$table->integer('expenditure')->default('0'); // TO be filled after the event has ended
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('internal_participants_count')->default('0'); // TO be filled after the event has ended
			$table->integer('external_participants_count')->default('0'); // TO be filled after the event has ended
            $table->boolean('is_completed')->default('0');
            $table->text('additional_columns');

            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
		Schema::drop('events');
	}

}
