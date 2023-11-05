<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\TraitApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        /**
         * 
         * keys in UserStoreRequest::$fieldsAndRules array to ignore.
         * 
         */
        $exceptsKeys = ['password', 'email'];

        $rules = [];

        foreach (UserStoreRequest::$fieldsAndRules as $key => $fAr) {
            if (!in_array($key, $exceptsKeys)) {
                $rules[$key] = $fAr;

                // find a field with a 'unique' rule
                $finded = array_filter($fAr, function ($i) {
                    return str_starts_with($i, 'unique:');
                });

                // update 'unique' rule
                if (current($finded)) {
                    $changed = $finded[array_key_last($finded)] . ',' . $this->user?->id ?? \Auth::user()->id;
                    $rules[$key][array_key_last($finded)] = $changed;
                }
            }
        }

        return $rules;
    }
}