<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\TraitApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
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
        $updateRules = [];

        if ($this->role) {
            $updateRules = [
                'manageables' => ['required', 'array'],
                'manageables.*' => [
                    'required',
                    'array',
                    function ($attr, $val, $call) {
                        [, $manageable] = explode('.', $attr);

                        // validate manageable type
                        if (!in_array($manageable, array_keys(\App\Models\Role::getManageables()))) {
                            $call("Manageable type '" . $manageable . "' not allowed");
                        }
                    }
                ],
                'manageables.*.*' => [
                    'required',
                    'boolean',
                    function ($attr, $val, $call) {
                        [, $manageable, $action] = explode('.', $attr);

                        // validate action
                        if (!in_array($action, array_keys(\App\Models\Role::getManageables()[$manageable] ?? []))) {
                            $call("Manageable action '" . $action . "' not allowed");
                        }
                    }
                ]
            ];
        }

        return array_merge([
            'name' => ['required', 'max:25']
        ], $updateRules);
    }
}
