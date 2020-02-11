<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('price');
            $table->string('description');
            $table->string('location');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('stock');
            $table->boolean('show_number')->nullable();
            $table->tinyInteger('is_sold')->default('0');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('category_id')
            ->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('status_id')
            ->references('id')->on('statuses')->onDelete('cascade');
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
        Schema::dropIfExists('items');
    }
}
