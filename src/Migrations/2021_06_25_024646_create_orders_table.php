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
            $table->foreignId('provider_id');
            $table->string('recipient_name', 255);
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 255);
            $table->string('postal_code', 10);
            $table->string('country', 255);
            $table->string('telephone', 15)->nullable();
            $table->string('mobile', 15)->nullable();
            $table->double('discounted');
            $table->double('total');
            $table->double('shipping_cost')->default(0);
            $table->double('payed');
            $table->text('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->text('tracking_number')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });

        Schema::table(config('badaso.database.prefix').'orders', function (Blueprint $table) {
            $table->foreign('provider_id')->references('id')->on(config('badaso.database.prefix').'payment_providers');
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
