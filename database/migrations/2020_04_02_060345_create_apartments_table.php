<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')
            ->references('id')->on('items')->onDelete('cascade');
            $table->integer('type')->nullable();
            $table->integer('types_type')->nullable();
            $table->integer('is_selling')->nullable();
            $table->string('room_count')->nullable();
            $table->integer('is_far_from_city')->nullable();
            $table->double('height')->nullable();
            $table->double('width')->nullable();
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
        Schema::dropIfExists('apartments');
    }
}
