<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regiments', function (Blueprint $table) {
            $table->integer("regimentID")->unique();
            $table->integer("doctorID");
            $table->integer("patientID");
            $table->date("date");
            $table->string("comment");
            $table->integer("morningMed");
            $table->integer("afternoonMed");
            $table->integer("eveningMed");
            $table->timestamps();

            $table->primary("regimentID");
            $table->foreign("doctorID")->references("userID")->on("users");
            $table->foreign("patientID")->references("userID")->on("users");
            $table->foreign("morningMed")->references("medicationID")->on("medications");
            $table->foreign("afternoonMed")->references("medicationID")->on("medications");
            $table->foreign("eveningMed")->references("medicationID")->on("medications");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regiments');
    }
};
