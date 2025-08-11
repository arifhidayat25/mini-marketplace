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
        Schema::create('banners', function (Blueprint $table) {
    $table->id();
    $table->string('image_url');
    $table->string('title')->nullable(); // Judul untuk referensi admin
    $table->string('link_url')->nullable(); // URL tujuan jika banner diklik
    $table->boolean('is_active')->default(true); // Untuk mengaktifkan/menonaktifkan banner
    $table->integer('order')->default(0); // Untuk urutan tampilan
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
