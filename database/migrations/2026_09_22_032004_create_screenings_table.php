<?php

use App\Enums\RiskStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('tensi_sistol'); // mmHg
            $table->unsignedSmallInteger('tensi_diastol'); // mmHg
            $table->decimal('hb_level', 4, 1); // g/dL
            $table->json('keluhan')->nullable(); // array keluhan
            $table->enum('risk_status', array_column(RiskStatus::cases(), 'value'))
                  ->default(RiskStatus::HIJAU->value);
            $table->timestamps();

            $table->index(['patient_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screenings');
    }
};
