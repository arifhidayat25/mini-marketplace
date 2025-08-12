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
Schema::create('addresses', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Terhubung ke user & akan terhapus jika user dihapus
    $table->string('label'); // Contoh: "Rumah", "Kantor", "Apartemen"
    $table->string('recipient_name'); // Nama penerima
    $table->string('phone');
    $table->text('full_address');
    $table->boolean('is_primary')->default(false); // Untuk menandai alamat utama
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
