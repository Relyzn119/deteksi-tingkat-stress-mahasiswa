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
        Schema::create('diagnosa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('jumlah_utama')->default(0);
            $table->integer('jumlah_tambahan')->default(0);
            $table->float('hasil_cf')->default(0.0);
            $table->float('persentase')->default(0.0);
            $table->string('hasil_diagnosa');
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosa');
    }
};
