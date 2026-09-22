<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('nik', 16)->nullable()->unique()->after('user_id');
            $table->string('alamat')->nullable()->after('tanggal_lahir');
            $table->unsignedTinyInteger('jumlah_anak')->default(0)->after('alamat');
            $table->date('hpht')->nullable()->after('jumlah_anak'); // Hari Pertama Haid Terakhir
            $table->decimal('berat_badan', 5, 2)->nullable()->after('tinggi_badan'); // kg
            $table->decimal('lila', 4, 2)->nullable()->after('berat_badan'); // Lingkar Lengan Atas (cm)
            $table->string('golongan_darah', 3)->nullable()->after('lila');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat', 'jumlah_anak', 'hpht', 'berat_badan', 'lila', 'golongan_darah']);
        });
    }
};
