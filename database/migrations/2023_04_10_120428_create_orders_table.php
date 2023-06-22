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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->float('sub_total')->default(0);
            $table->float('total_amount')->default(0);
            $table->float('coupon')->nullable()->default(0);
            $table->float('delivery_charge')->nullable()->default(0);
            $table->integer('quantity')->default(0);
            $table->enum('order_status', ['new','pending','processing', 'delivered', 'canceled'])->default('new');
            
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('country');
            $table->string('street');
            $table->string('town');
            $table->string('apartment')->nullable();
            $table->string('state');
            $table->string('postcode');
            //shipping
            $table->string('ship_fullname');
            $table->string('ship_email')->unique();
            $table->string('ship_phone_number')->unique();
            $table->string('ship_country');
            $table->string('ship_street');
            $table->string('ship_town');
            $table->string('ship_apartment')->nullable();
            $table->string('ship_state');
            $table->string('ship_postcode');
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
        Schema::dropIfExists('orders');
    }
};
