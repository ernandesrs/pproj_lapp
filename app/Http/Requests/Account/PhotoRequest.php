<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\TraitApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
            'photo' => ['required', 'file', 'max:1024', 'dimensions:min_width=250,min_height=250', 'mimes:png,jpg']
        ];
    }
}