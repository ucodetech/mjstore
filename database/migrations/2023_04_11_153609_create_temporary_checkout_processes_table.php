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
        Schema::create('temporary_checkout_processes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->unique()->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->float('sub_total')->nullable()->default(0);
            $table->float('total_amount')->nullable()->default(0);
            $table->float('coupon')->nullable()->default(0);
            $table->float('delivery_charge')->nullable()->default(0);
            $table->integer('quantity')->nullable()->default(0);
            $table->enum('order_status', ['new','pending','processing', 'delivered', 'canceled'])->nullable()->default('new');
            
            $table->string('fullname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('country')->nullable();
            $table->string('street')->nullable();
            $table->string('town')->nullable();
            $table->string('apartment')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            //shipping
            $table->string('ship_fullname')->nullable();
            $table->string('ship_email')->nullable()->unique();
            $table->string('ship_phone_number')->nullable()->unique();
            $table->string('ship_country')->nullable();
            $table->string('ship_street')->nullable();
            $table->string('ship_town')->nullable();
            $table->string('ship_apartment')->nullable();
            $table->string('ship_state')->nullable();
            $table->string('ship_postcode')->nullable();
            $table->text('order_notes')->nullable();

            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('NO ACTION');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temporary_checkout_processes');
    }
};
