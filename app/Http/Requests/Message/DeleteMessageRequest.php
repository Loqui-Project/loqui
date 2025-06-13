<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

final class DeleteMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /* @var User $user */
        $user = Auth::user();

        if ($user === null) {
            return false;
        }

        return $user->can('delete', Message::find($this->message_id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'message_id' => ['required', 'exists:messages,id'],
        ];
    }
}
