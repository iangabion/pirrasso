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
            $table->string('title')->nullable();
            $table->integer('price');
            $table->string('description')->nullable();
            $table->string('brand')->nullable();
            $table->string('variation')->nullable();
            $table->string('location')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->integer('stock');
            $table->integer('is_urgent')->nullable();
            $table->integer('is_expired')->nullable();
            $table->integer('is_displayed')->nullable();
            $table->integer('is_active')->nullable();
            $table->boolean('show_number')->nullable();
            $table->tinyInteger('is_sold')->default('0');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable()->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
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
