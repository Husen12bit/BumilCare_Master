<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->unsignedTinyInteger('usia_kehamilan_minggu')->nullable()->after('patient_id');
            $table->decimal('berat_badan', 5, 2)->nullable()->after('usia_kehamilan_minggu');
            $table->decimal('lila', 4, 2)->nullable()->after('berat_badan');
            $table->boolean('ttd_7_hari_terakhir')->default(false)->after('keluhan');
        });
    }

    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropColumn(['usia_kehamilan_minggu', 'berat_badan', 'lila', 'ttd_7_hari_terakhir']);
        });
    }
};
