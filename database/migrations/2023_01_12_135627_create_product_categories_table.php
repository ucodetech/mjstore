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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->string('photo')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('parent_id');
            $table->boolean('is_parent')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
            // $table->foreign('parent_id')->references('id')->on('product_categories')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
