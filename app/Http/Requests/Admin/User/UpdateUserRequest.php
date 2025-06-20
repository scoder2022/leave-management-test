<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return [
            'name' => 'required|max:60|unique:users,name,'.$this->request->get('id'),
            'email'=>'required|email|max:200|unique:users,email,'.$this->request->get('id'),
            'password' => 'nullable|confirmed|min:6',
            'status' => 'required|boolean',
    ];
    }
}
