<?php

namespace App\Http\Requests\Admin\Setting;

use App\Http\Requests\TraitApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class EmailSenderRequest extends FormRequest
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
            'display_name' => ['required', 'max:20', 'unique:email_senders,display_name' . ($this->email_sender?->id ? (',' . $this->email_sender->id) : '')],
            'default' => ['nullable', 'boolean'],
            'host' => ['required', 'string'],
            'port' => ['required', 'numeric'],
            'encrypt' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'from_mail' => ['required', 'email']
        ];
    }
}
