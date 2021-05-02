<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColonySectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colony_section', function (Blueprint $table) {
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->bigInteger('colony_id')->unsigned()->nullable();
            $table->timestamps();

            #Relations
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('colony_id')->references('id')->on('colonies')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colony_section');
    }
}
