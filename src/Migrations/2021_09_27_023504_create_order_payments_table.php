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
            $table->foreignId('order_id')->constrained(config('badaso.database.prefix').'orders');
            $table->string('payment_type')->default('manual_bank_transfer');
            $table->string('source_bank');
            $table->string('destination_bank');
            $table->string('account_number');
            $table->string('total_transfered');
            $table->text('proof_of_transaction');
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
