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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id(); // Kolom ID unik
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('item_name'); // Nama item
            $table->integer('quantity');
            $table->dateTime('transaction_date'); // Tanggal dan waktu transaksi
            $table->string('payment_method'); // Metode pembayaran
            $table->string('item_category'); // Kategori item
            $table->decimal('price', 10, 2); // Harga item
            $table->decimal('total_price', 10, 2);
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
