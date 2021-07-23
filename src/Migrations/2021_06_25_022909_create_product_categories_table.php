<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'product_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->text('desc')->nullable();
            $table->string('SKU', 255)->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        Schema::table(config('badaso.database.prefix').'product_categories', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on(config('badaso.database.prefix').'product_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'product_categories');
    }
}
