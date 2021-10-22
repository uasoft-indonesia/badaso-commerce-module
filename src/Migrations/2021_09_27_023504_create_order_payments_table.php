<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('order_id')->constrained(config('badaso.database.prefix').'orders');
            $table->string('payment_type');
            $table->string('source_bank')->nullable();
            $table->string('destination_bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('total_transfered')->nullable();
            $table->text('proof_of_transaction')->nullable();
            $table->text('token')->nullable();
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
        Schema::dropIfExists(config('badaso.database.prefix').'order_payments');
    }
}
