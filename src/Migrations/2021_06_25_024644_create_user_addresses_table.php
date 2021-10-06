<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('badaso.database.prefix').'user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(config('badaso.database.prefix').'users');
            $table->string('recipient_name', 255);
            $table->string('address_line1', 255);
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 255);
            $table->string('postal_code', 10);
            $table->string('country', 2);
            $table->string('phone_number', 15);
            $table->boolean('is_main')->default(0);
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
        Schema::dropIfExists(config('badaso.database.prefix').'user_addresses');
    }
}
