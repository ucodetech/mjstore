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
        Schema::create('superusers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('super_fullname');
            $table->string('username')->unique();
            $table->string('super_email')->unique();
            $table->string('super_uniqueid')->unique();
            $table->boolean('super_email_verified')->nullable()->default(false);
            $table->string('super_phone_no')->unique();
            $table->string('password');
            $table->string('portfolio')->unique();
            $table->string('super_profile_photo')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['superuser', 'editor'])->default('superuser');
            $table->boolean('deleted')->nullable()->default(false);
            $table->boolean('is_superuser')->nullable()->default(false);
            $table->boolean('device_Verified')->nullable()->default(false);
            $table->boolean('email_changed')->nullable()->default(false);
            $table->timestamp('super_last_login')->default(Carbon::now());
            $table->timestamp('super_date_added')->default(Carbon::now());
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('superusers');
    }
};
