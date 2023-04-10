<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadasoPaymentTypeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'payment_type_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')->constrained(config('badaso.database.prefix').'payment_types')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->text('image')->nullable();
            $table->boolean('is_active');
            $table->integer('order');
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
        Schema::dropIfExists(config('badaso.database.prefix').'payment_type_options');
    }
}
