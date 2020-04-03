<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
            ->references('id')->on('items')->onDelete('cascade');
            $table->integer('type')->nullable();
            $table->integer('types_type')->nullable();
            $table->integer('is_selling')->nullable();
            $table->integer('fuel')->nullable();
            $table->integer('kilometer')->nullable();
            $table->integer('can_offroad')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
