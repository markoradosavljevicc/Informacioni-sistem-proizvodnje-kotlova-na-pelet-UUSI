<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kupac_id' => ['required', 'integer', 'exists:kupacs,id'],
            'proizvod_id' => ['required', 'integer', 'exists:proizvods,id'],
            'datum_prijave' => ['required', 'date'],
            'datum_zavrsetka' => ['nullable', 'date'],
            'opis_kvara' => ['required', 'string', 'max:2000'],
            'opis_popravke' => ['nullable', 'string', 'max:2000'],
            'status' => ['nullable', 'string'],
            'serviser_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
