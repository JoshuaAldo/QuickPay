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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('base_price', 15, 2);
            $table->decimal('sell_price', 15, 2);
            $table->integer('stock');
            $table->foreignId('category_id')->nullable()->constrained('product_categories');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tambahkan user_id sebagai foreign key
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
