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
        Schema::create(config('badaso.database.prefix').'product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained(config('badaso.database.prefix').'products')->onDelete('cascade');
            $table->foreignId('order_detail_id')->constrained(config('badaso.database.prefix').'order_details')->onDelete('cascade');
            $table->foreignId('user_id')->constrained(config('badaso.database.prefix').'users')->onDelete('cascade');
            $table->tinyInteger('rating');
            $table->text('review')->nullable();
            $table->text('media')->nullable();
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
        Schema::dropIfExists(config('badaso.database.prefix').'product_reviews');
    }
}
