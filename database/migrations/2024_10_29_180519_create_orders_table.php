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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->dateTime('order_date');
            $table->string('payment_method');
            $table->decimal('payment_amount', 10, 2);
            $table->decimal('cash_amount', 10, 2)->nullable();
            $table->decimal('qr_amount', 10, 2)->nullable();
            $table->string('settlement_status');
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
