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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->constrained('users')->onDelete('cascade');
            $table->date('start_date');
            $table->date('deadline');
            $table->string('status')->default('Belum Dimulai'); // Belum Dimulai, Dalam Proses, Selesai, Terlambat
            $table->tinyInteger('transaction_method')->default(1); // 1 = Pengadaan Langsung, 2 = e-Purchasing, 3 = Lelang
            $table->tinyInteger('current_step')->default(0); // 0 = Belum dikerjakan, 1 = Persiapan, 2 = Pengajuan, 3 = Pengerjaan, 4 = Pembayaran, 5 = Selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
