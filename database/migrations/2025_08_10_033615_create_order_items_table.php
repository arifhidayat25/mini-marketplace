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
        // dalam fungsi up()
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('order_id')->constrained()->cascadeOnDelete(); // Jika order dihapus, itemnya ikut terhapus
    $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete(); // Jika produk dihapus, itemnya tetap ada
    $table->integer('quantity');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
