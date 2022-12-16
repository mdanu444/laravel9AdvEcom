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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_sections_id');
            $table->foreignId('product_categories_id');
            $table->foreignId('product_sub_categories_id')->default(0);
            $table->foreignId('brands_id');
            $table->string('title');
            $table->string('code');
            $table->string('color');
            $table->string('unit');
            $table->float('weight');
            $table->float('price');
            $table->float('discount');
            $table->tinyInteger('featured')->default(0);
            $table->string('video');
            $table->string('image');
            $table->text('description');
            $table->string('wash_care');
            $table->string('fabric');
            $table->string('pattern');
            $table->string('sleeve')->nullable();
            $table->string('fit');
            $table->string('occassion');
            $table->string('meta_title');
            $table->string('meta_keywords');
            $table->text('meta_description');
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
        Schema::dropIfExists('products');
    }
};
