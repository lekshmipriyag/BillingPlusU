<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('sp_relations');
        Schema::create('sp_relations', function (Blueprint $table) {
            // Primary key and foreign key id
            $table->bigIncrements('id');
            $table->unsignedBigInteger('specialist_id');
            $table->unsignedBigInteger('processor_id');

            // Attributes
            $table->text('status');
            $table->timestamps();

            // Foreign key relation
            $table->foreign('specialist_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('processor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_relations');
    }
}
