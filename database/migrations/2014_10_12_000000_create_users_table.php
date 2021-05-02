<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('lastname');
            $table->string('photo')->default('usuario.png');
            $table->string('slug')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->enum('state', [0, 1])->default(1);
            $table->rememberToken();
            $table->bigInteger('colony_id')->unsigned()->nullable();
            $table->bigInteger('section_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            #Relations
            $table->foreign('colony_id')->references('id')->on('colonies')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
