<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeterinarianRequest extends FormRequest
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
            'last_name' => ['required'],
            'first_name' => ['required'],
            'email' => ['required', 'email', 'unique:veterinarians'],
            'contact_number' => ['required'],
            'specialization' => ['required'],
            'status' => Rule::enum(Status::class)
        ];

        if ($this->isMethod('PUT')) {
            $rules['email'] = ['required', 'email', Rule::unique('veterinarians')->ignore($this->veterinarian->id)];
        }

        return $rules;
    }
}
