<?php

namespace App\Http\Requests\API\Message;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddReplayToMessageRequest extends FormRequest
{
    use FailedValidationTrait;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $messageId = $this->only("message_id")["message_id"];
        $message = $this->user()->messages()->where("id", $messageId)->first();
        if ($message === null) {
            return false;
        }
        return Auth::check() && Auth::user()->id === $message->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "message_id" => "required|exists:messages,id",
            "replay" => "required|string",
        ];
    }


    public function getMessageId(): int
    {
        return $this->only("message_id")["message_id"];
    }

    public function getData(): array
    {
        return [
            ...$this->except("message_id"),
            "user_id" => Auth::id(),
        ];
    }
}
