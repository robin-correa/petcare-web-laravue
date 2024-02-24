<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            'status' => Rule::enum(Status::class),
            'role' => ['required', 'exists:roles,id']
        ];

        if ($this->isMethod('PUT')) {
            $rules['email'] = ['required', 'email', Rule::unique('users')->ignore($this->user->id)];
            unset($rules['password']);
            unset($rules['password_confirm']);
        }

        return $rules;
    }
}
