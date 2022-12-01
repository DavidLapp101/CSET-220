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
        Schema::create('dailytasks', function (Blueprint $table) {
            $table->date("date");
            $table->integer("patientID");
            $table->boolean("morningMed");
            $table->boolean("afternoonMed");
            $table->boolean("eveningMed");
            $table->boolean("breakfast");
            $table->boolean("lunch");
            $table->boolean("dinner");
            $table->timestamps();

            $table->foreign("patientID")->references("userID")->on("users");
            $table->primary(['date', 'patientID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dailytasks');
    }
};
