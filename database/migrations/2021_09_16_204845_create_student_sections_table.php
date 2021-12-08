<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')
				->on('sections')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')
				->on('students')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_sections');
    }
}
