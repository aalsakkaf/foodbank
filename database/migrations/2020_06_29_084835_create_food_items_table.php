<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foodItems', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->set('quantityType', ['KG','Piece/s']);
            $table->smallInteger('quantity');
            $table->string('photoURL')->nullable();
            $table->unsignedBigInteger('donation_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('donation_id')->references('id')->on('donations')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('food_categories')->onDelete('cascade');
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
        Schema::dropIfExists('food_items');
    }
}
