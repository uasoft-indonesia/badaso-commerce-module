<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('desc')->nullable();
            $table->enum('discount_type', ['fixed', 'percent']);
            $table->float('discount_percent')->nullable();
            $table->double('discount_fixed')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix').'discounts');
    }
}
