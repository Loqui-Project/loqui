<?php

declare(strict_types=1);

namespace App\Http\Requests\Settings;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, list<\Illuminate\Contracts\Validation\ValidationRule|string|null>|string>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
            'username' => [
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()?->id),
            ],
            'image' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048',
        ];
    }
}
