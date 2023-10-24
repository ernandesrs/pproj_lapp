<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\TraitApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    use TraitApiRequest;

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
            'first_name' => ['required', 'max:25'],
            'last_name' => ['required', 'max:50'],
            'username' => ['required', 'max:25', 'unique:users,username'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:6', 'max:12', 'confirmed']
        ];
    }
}