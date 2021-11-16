<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('claims');
        Schema::create('claims', function (Blueprint $table) {
            // Primary key and foreign key id
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();

            // Attributes
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('referral_length')->nullable();
            $table->date('referral_date')->nullable();
            $table->date('date_of_services')->nullable();
            $table->text('item_numbers')->nullable();
            $table->text('notes')->nullable();
            $table->text('image_path')->nullable();
            $table->timestamps();
            $table->string('status');

            // Foreign key relation
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claims');
    }
}
