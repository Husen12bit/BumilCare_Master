<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScreeningResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tensi_sistol' => $this->tensi_sistol,
            'tensi_diastol' => $this->tensi_diastol,
            'hb_level' => $this->hb_level,
            'keluhan' => $this->keluhan,
            'risk_status' => $this->risk_status->value,
            'risk_label' => $this->risk_status->label(),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
