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
        Schema::create('permohonan_upgrade', function (Blueprint $table) {
            $table->bigIncrements('permohonan_id');
            $table->foreignId('user_id')
                ->references('user_id')
                ->on('user')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('tanggal_permohonan');
            $table->string('nama_lengkap', 100);
            $table->string('nomor_hp', 15);
            $table->string('nama_usaha', 100);
            $table->string('alamat_lengkap', 100);
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak']);
            $table->text('catatan_admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_upgrade');
    }
};
