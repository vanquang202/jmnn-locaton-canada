<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('location_american', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->longText('code');
            $table->longText('state');
            $table->integer('level');
            $table->longText('address');
            $table->longText('street')->nullable();
            $table->longText('no_street')->nullable();
            $table->longText('postal')->nullable();
            $table->longText('full_state_postal');
            $table->longText('lat')->nullable();
            $table->longText('long')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('location_american');
    }
};
