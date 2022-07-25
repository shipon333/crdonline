<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('device_type_id')->constrained();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->boolean('condition')->default(0);
            $table->string('last_updated')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('subnet_mask')->nullable();
            $table->string('gateway')->nullable();
            $table->string('dns_1')->nullable();
            $table->string('dns_2')->nullable();
            $table->string('dns_achtervoegesl')->nullable();
            $table->string('terminal_model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('sim_card')->nullable();
            $table->string('sim_serial_number')->nullable();
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
        Schema::dropIfExists('devices');
    }
}
