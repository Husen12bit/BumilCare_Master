<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'jumlah_anak' => ['nullable', 'integer', 'min:0', 'max:20'],
            'hpht' => ['nullable', 'date', 'before:today'],
            'tinggi_badan' => ['nullable', 'numeric', 'min:100', 'max:220'],
            'berat_badan' => ['nullable', 'numeric', 'min:20', 'max:200'],
            'lila' => ['nullable', 'numeric', 'min:10', 'max:50'],
        ];
    }
}
