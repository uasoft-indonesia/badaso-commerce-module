<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id');
            $table->foreignId('discount_id')->nullable();
            $table->string('name', 255);
            $table->bigInteger('quantity');
            $table->double('price');
            $table->string('SKU', 255)->nullable();
            $table->text('product_image');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        Schema::table(config('badaso.database.prefix').'product_details', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on(config('badaso.database.prefix').'products')->onDelete('cascade');
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
        Schema::dropIfExists(config('badaso.database.prefix').'product_details');
    }
}
