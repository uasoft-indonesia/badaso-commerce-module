<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained(config('badaso.database.prefix').'users');
            $table->double('discounted');
            $table->double('total');
            $table->double('shipping_cost')->default(0);
            $table->double('payed');
            $table->enum('status', ['waitingBuyerPayment', 'waitingSellerConfirmation', 'process', 'delivering', 'done', 'cancel']);
            $table->text('tracking_number')->nullable();
            $table->string('message')->nullable();
            $table->string('cancel_message')->nullable();
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists(config('badaso.database.prefix').'orders');
    }
}
