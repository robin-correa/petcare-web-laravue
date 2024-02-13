<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
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
            'name' => ['required', 'unique:services'],
            'description' => ['required'],
            'min_price' => ['required', 'integer'],
            'max_price' => ['required', 'integer'],
            'status' => Rule::enum(Status::class)
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = ['required', Rule::unique('services')->ignore($this->service->id)];
        }

        return $rules;
    }
}
