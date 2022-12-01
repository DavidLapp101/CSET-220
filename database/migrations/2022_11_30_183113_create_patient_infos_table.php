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
        Schema::create('patientinfo', function (Blueprint $table) {
            $table->integer("userID");
            $table->string("familyCode");
            $table->bigInteger("emergencyContact");
            $table->string("contactName");
            $table->string("contactRelation");
            $table->integer("groupNum");
            $table->date("admissionDate");
            $table->decimal("balance", 11, 2);
            $table->timestamps();

            $table->foreign("userID")->references("userID")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patientinfo');
    }
};
