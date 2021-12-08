<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('partylist_id')->nullable();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('election_id');
            $table->unsignedBigInteger('position_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('partylist_id')->references('id')
				->on('partylists')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->foreign('student_id')->references('id')
				->on('students')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->foreign('election_id')->references('id')
				->on('elections')
				->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('position_id')->references('id')
                ->on('positions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
