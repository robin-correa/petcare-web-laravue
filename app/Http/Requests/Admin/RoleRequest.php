<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
            'name' => ['required', 'unique:roles'],
            'guard_name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer']
        ];

        if ($this->isMethod('PUT')) {
            $rules['name'] = ['required', Rule::unique('roles')->ignore($this->role->id)];
        }

        return $rules;
    }
}