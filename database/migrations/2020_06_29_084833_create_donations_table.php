<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->dateTimeTz('availableDate')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('rewardPoint_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('rewardPoint_id')->references('id')->on('reward_points')->onDelete('cascade');
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
        Schema::dropIfExists('donations');
    }
}
