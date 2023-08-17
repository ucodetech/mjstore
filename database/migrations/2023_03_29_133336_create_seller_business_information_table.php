<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_business_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('seller_id');
            $table->string('shop_address');
            $table->string('shop_city');
            $table->string('shop_state');
            $table->string('shop_logo');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number', 10)->unique();
            $table->string('registered_biz_name')->unique();
            $table->string('cac_registration_no')->unique();
            $table->string('cac_certificate');
            $table->string('customer_support_email')->unique();
            $table->string('customer_support_phone_no', 15)->unique();
            $table->string('customer_support_whatsapp', 15)->unique();
            $table->tinyInteger('approved')->default(0);
            $table->timestamps();
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_business_information');
    }
};
