<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = $this->route('user');
        $emailRule = Rule::unique('users', 'email');
        $passwordRules = ['required', 'string', 'min:8', 'confirmed'];

        if ($user instanceof User) {
            $emailRule->ignore($user->id);
            $passwordRules = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', $emailRule],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => $passwordRules,
        ];
    }
}
