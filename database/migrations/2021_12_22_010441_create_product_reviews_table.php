<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('solds_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('items_id');
            $table->unsignedBigInteger('buyer_id');
            $table->foreign('solds_id')->references('id')
                ->on('solds')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')
                ->on('clients')->onDelete('cascade');
            $table->foreign('items_id')->references('id')
                ->on('items')->onDelete('cascade');
            $table->string('rating');
            $table->string('review_description')->nullable();
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
        Schema::dropIfExists('product_reviews');
    }
}
