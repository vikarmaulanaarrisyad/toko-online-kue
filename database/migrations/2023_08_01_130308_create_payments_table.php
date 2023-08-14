<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('payment_status', ['pending', 'success', 'failure'])->default('pending');
            $table->string('payment_method');
            $table->integer('payment_amount')->default(0);
            $table->unsignedBigInteger('transaction_id')->nullable()->comment('ID transaksi dari Midtrans ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
