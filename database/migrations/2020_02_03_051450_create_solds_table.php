<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('buyer_id');
            $table->integer('quantity')->nullable();
            $table->timestamps();
            $table->foreign('seller_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('item_id')->references('id')
                ->on('items')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')
                ->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solds');
    }
}
