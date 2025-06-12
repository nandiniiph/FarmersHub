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
        Schema::create('detail_keranjang', function (Blueprint $table) {
            $table->bigIncrements('detail_keranjang_id');
            $table->foreignId('cart_id')
                ->references('cart_id')
                ->on('keranjang')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->references('product_id')
                ->on('produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_keranjang');
    }
};
