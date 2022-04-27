<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddPaypaToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            Schema::table('items', function (Blueprint $table){
                $table->string('cod_shipping_fee')->after('subcategory_id')->nullable();
                $table->string('paypal_address')->after('cod_shipping_fee')->nullable();
                $table->string('pickup_address')->after('paypal_address')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}
