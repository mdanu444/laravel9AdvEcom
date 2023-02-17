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
        Schema::create('shipping_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('districts_id');
            $table->float('weight_0_500g');
            $table->float('weight_501_1000g');
            $table->float('weight_1001_2000g');
            $table->float('weight_2001_5000g');
            $table->float('weight_5001g_above');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_charges');
    }
};
