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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('photo');
            $table->string('slug')->unique();
            $table->string('unique_key')->unique();
            $table->boolean('home_shop')->default(false);
            $table->text('summary');
            $table->longText('description');
            $table->integer('stock');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('cat_id');
            $table->unsignedBigInteger('child_cat_id')->nullable();
            $table->float('price')->default(0);
            $table->float('sales_price')->default(0);
            $table->float('product_discount')->default(0);
            $table->float('weights')->nullable()->default(0);
            $table->float('size')->nullable()->default(0);
            $table->float('color')->nullable()->default(0);
            $table->enum('condition', ['new', 'popular'])->default('new');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('featured')->default(false);
            $table->timestamps();
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('cat_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('child_cat_id')->references('id')->on('product_categories')->onDelete('SET NULL');
            $table->foreign('vendor_id')->references('id')->on('sellers')->onDelete('SET NULL');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
