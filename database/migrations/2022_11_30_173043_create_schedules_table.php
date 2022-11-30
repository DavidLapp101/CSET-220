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
        Schema::create('schedules', function (Blueprint $table) {
            $table->date("date")->unique();
            $table->integer("supervisor");
            $table->integer("doctorOne");
            $table->integer("doctorTwo");
            $table->integer("groupOneCarer");
            $table->integer("groupTwoCarer");
            $table->integer("groupThreeCarer");
            $table->integer("groupFourCarer");
            $table->timestamps();

            $table->primary("date");
            $table->foreign("supervisor")->references("userID")->on("users");
            $table->foreign("doctorOne")->references("userID")->on("users");
            $table->foreign("doctorTwo")->references("userID")->on("users");
            $table->foreign("groupOneCarer")->references("userID")->on("users");
            $table->foreign("groupTwoCarer")->references("userID")->on("users");
            $table->foreign("groupThreeCarer")->references("userID")->on("users");
            $table->foreign("groupFourCarer")->references("userID")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
