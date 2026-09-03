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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->unique()->after('id');
            $table->string('jk')->nullable()->after('password'); // Laki-laki / Perempuan
            $table->integer('umur')->nullable()->after('jk');
            $table->string('prodi')->nullable()->after('umur');
            $table->integer('semester')->nullable()->after('prodi');
            $table->string('role')->default('user')->after('semester'); // admin / user
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nim', 'jk', 'umur', 'prodi', 'semester', 'role']);
        });
    }
};
