<?php

namespace App\Http\Requests\API\Message;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SendMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sender_id' => 'required|integer|exists:users,id',
            'user_id' => 'required|integer|exists:users,id|different:sender_id',
            'message' => 'required|string|max:255',
        ];
    }
}
