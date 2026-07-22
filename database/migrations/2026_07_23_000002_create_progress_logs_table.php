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
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade');
            $table->tinyInteger('step'); // 0 = Belum dikerjakan, 1 = Persiapan, 2 = Pengajuan, 3 = Pengerjaan, 4 = Pembayaran, 5 = Selesai
            $table->text('description');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_logs');
    }
};
