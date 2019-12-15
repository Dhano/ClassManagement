<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnquiryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enquiry', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('student_name');
			$table->text('student_address');
			$table->text('student_number');
            $table->text('student_college');
            $table->text('student_year');
            $table->text('student_branch');

            $table->text('comments');

            $table->text('additional_columns')->nullable();
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
		Schema::drop('enquiry');
	}

}
