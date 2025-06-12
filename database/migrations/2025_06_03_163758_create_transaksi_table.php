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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('transaksi_id');
            $table->foreignId('user_id')
                ->references('user_id')
                ->on('user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->decimal('total_harga');
            $table->enum('status', ['Pending', 'Lunas', 'Batal']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
