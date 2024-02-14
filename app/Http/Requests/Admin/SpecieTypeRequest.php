<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpecieTypeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'unique:specie_types'],
            'description' => ['required'],
            'status' => ['required', Rule::enum(Status::class)]
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = ['required', Rule::unique('specie_types')->ignore($this->specieType->id)];
        }

        return $rules;
    }
}
