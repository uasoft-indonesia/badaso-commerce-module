<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_detail_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('quantity');
            $table->timestamps();
        });
        
        Schema::table(config('badaso.database.prefix').'carts', function (Blueprint $table) {
            $table->foreign('product_detail_id')->references('id')->on(config('badaso.database.prefix').'product_details');
            $table->foreign('user_id')->references('id')->on(config('badaso.database.prefix').'users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'carts');
    }
}
