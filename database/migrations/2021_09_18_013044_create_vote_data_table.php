<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_id');
            $table->foreign('vote_id')->references('id')
                ->on('votes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references('id')
                ->on('positions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->references('id')
                ->on('candidates')
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
        Schema::dropIfExists('vote_data');
    }
}
