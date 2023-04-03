<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadasoOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix') . 'order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id')->constrained(config('badaso.database.prefix') . 'orders');
            $table->foreignId('payment_type_option_id')->nullable();
            $table->string('source_bank')->nullable();
            $table->string('destination_bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('total_transfered')->nullable();
            $table->text('proof_of_transaction')->nullable();
            $table->text('token')->nullable();
            $table->timestamps();
        });

        Schema::table(config('badaso.database.prefix') . 'order_payments', function (Blueprint $table) {
            $table->foreign('payment_type_option_id')->references('id')->on(config('badaso.database.prefix') . 'payment_type_options')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('badaso.database.prefix') . 'order_payments');
    }
}
