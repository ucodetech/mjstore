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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('username')->nullable()->unique();
            $table->string('unique_id')->unique();
            $table->string('email')->unique();
            $table->boolean('email_verified')->nullable()->default(false);
            $table->string('phone_number')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->text('address');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('role', ['customer'])->default('customer');
            $table->boolean('deleted')->nullable()->default(false);
            $table->timestamp('last_login')->default(Carbon::now());
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
