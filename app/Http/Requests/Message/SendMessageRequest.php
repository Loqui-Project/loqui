<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class SendMessageRequest extends FormRequest
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
        return [
            'message' => ['required', 'string'],
            'receiver_id' => ['required', 'exists:users,id', 'different:user_id'],
            'is_anon' => ['boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
