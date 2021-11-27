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
            $table->integer('price');
            $table->string('description');
            $table->string('location');
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->integer('stock');
            $table->integer('is_urgent');
            $table->integer('is_expired');
            $table->integer('is_displayed');
            $table->integer('is_active');
            $table->boolean('show_number')->nullable();
            $table->tinyInteger('is_sold')->default('0');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('category_id')
            ->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('status_id')
            ->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('subcategory_id')
            ->references('id')->on('subcategories')->onDelete('cascade');
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
