<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('shop_name')->unique();
            $table->enum('business_options', ['individual', 'registered business'])->default('individual');
            $table->string('manager_fullname');
            $table->string('manager_tel')->unique();
            $table->string('manager_email')->unique();
            $table->string('username')->unique();
            $table->enum('role',['seller'])->default('seller');
            $table->string('password');
            $table->timestamp('manager_last_login')->default(Carbon::now());
            $table->timestamp('manager_date_added')->default(Carbon::now());
            $table->string('manager_profile_photo');
            $table->boolean('email_verified')->default(false);
            $table->boolean('device_verified')->default(false);
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->boolean('can_sell_now')->default(false);
            $table->boolean('email_changed')->default(false);


        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sellers');
    }
};
