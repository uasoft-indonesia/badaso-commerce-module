<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->nullable();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('product_image');
            $table->text('desc')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        Schema::table(config('badaso.database.prefix').'products', function (Blueprint $table) {
            $table->foreign('product_category_id')->references('id')->on(config('badaso.database.prefix').'product_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'products');
    }
}
