<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NarudzbinaStoreRequest extends FormRequest
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
            'datum_narudzbine' => ['required', 'date'],
            'rok_isporuke' => ['nullable', 'date', 'after:datum_narudzbine'],
            'ukupna_cena' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'string'],
            'napomena' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
