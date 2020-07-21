<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleFoodItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_foodItem', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bundle_id')->index();
            $table->unsignedBigInteger('foodItem_id')->index();
            $table->timestamps();
            
            $table->foreign('bundle_id')
            ->references('id')->on('bundles')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('foodItem_id')
            ->references('id')->on('foodItems')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_foodItem');
    }
}
