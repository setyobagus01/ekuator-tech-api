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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index('fk_transactions_to_users');
            $table->foreignId('product_id')->index('fk_transactions_to_products');
            $table->integer('price');
            $table->integer('quantity');
            $table->decimal('admin_fee', 11, 2);
            $table->decimal('tax', 11, 2);
            $table->decimal('total', 11, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id', 'fk_transactions_to_users')->references('id')->on('users');
            $table->foreign('product_id', 'fk_transactions_to_products')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
