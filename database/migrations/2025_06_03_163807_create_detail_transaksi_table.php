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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->bigIncrements('detail_transaksi_id');
            $table->foreignId('transaksi_id')
                ->references('transaksi_id')
                ->on('transaksi')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product_id')
                ->references('product_id')
                ->on('produk')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('jumlah');
            $table->decimal('harga_satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
