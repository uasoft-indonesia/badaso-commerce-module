<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->id();
            $table->foreignId('user_id')->constrained(config('badaso.database.prefix').'users');
            $table->string('recipient_name', 255);
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 255);
            $table->string('postal_code', 10);
            $table->string('country', 255);
            $table->string('phone_number', 15);
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
        Schema::dropIfExists(config('badaso.database.prefix').'orders');
    }
}
