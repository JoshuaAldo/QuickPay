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
        Schema::create('draft_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->timestamps(); // Untuk menyimpan waktu ketika draft disimpan
        });

        // Membuat tabel untuk item dalam draft order
        Schema::create('draft_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draft_order_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->decimal('product_price', 10, 2);
            $table->integer('quantity');
            $table->string('product_image');
            $table->text('description')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_order_items');
        Schema::dropIfExists('draft_orders');
    }
};
