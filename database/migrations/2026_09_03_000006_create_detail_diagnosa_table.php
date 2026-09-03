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
        Schema::create('detail_diagnosa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diagnosa_id')->constrained('diagnosa')->onDelete('cascade');
            $table->foreignId('gejala_id')->constrained('gejala')->onDelete('cascade');
            $table->float('cf_user')->default(0.0);
            $table->float('cf_hasil')->default(0.0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_diagnosa');
    }
};
