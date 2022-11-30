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
        Schema::create('appointments', function (Blueprint $table) {
            $table->integer("appointmentID")->unique();
            $table->integer("patientID");
            $table->integer("doctorID");
            $table->date("date");
            $table->timestamps();

            $table->primary("appointmentID");
            $table->foreign("patientID")->references("userID")->on("users");
            $table->foreign("doctorID")->references("userID")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
