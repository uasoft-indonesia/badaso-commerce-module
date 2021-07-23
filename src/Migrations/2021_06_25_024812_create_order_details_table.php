<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('product_detail_id');
            $table->foreignId('discount_id')->nullable();
            $table->double('price');
            $table->double('discounted');
            $table->bigInteger('quantity');
            $table->timestamps();
        });

        Schema::table(config('badaso.database.prefix').'order_details', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on(config('badaso.database.prefix').'orders');
            $table->foreign('product_detail_id')->references('id')->on(config('badaso.database.prefix').'product_details');
            $table->foreign('discount_id')->references('id')->on(config('badaso.database.prefix').'discounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'order_details');
    }
}
