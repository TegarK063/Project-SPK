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
        Schema::create('alternatifs', function (Blueprint $table) {
             $table->id();
            $table->string('kode_alternatif')->unique(); // contoh: A1, A2, dst
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            // relasi ke tabel products

            // nilai kriteria khusus (selain harga & storage yg sudah ada di products)
            $table->integer('performance');  // 1 - 100
            $table->integer('camera');       // 1 - 100
            $table->integer('battery');      // jam
            $table->tinyInteger('aftersales'); // 1 - 10

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternatifs');
    }
};
