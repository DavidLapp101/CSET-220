<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Unique;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('userID')->unique();
            $table->integer("roleID");
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('phone')->unique();
            $table->string('password');
            $table->date('dateOfBirth');
            $table->string('accountStatus');
            $table->timestamps();

            $table->primary("userID");
            $table->foreign('roleID')->references('roleID')->on('roles');
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
};
