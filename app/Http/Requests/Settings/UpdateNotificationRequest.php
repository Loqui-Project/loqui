<?php

declare(strict_types=1);

namespace App\Http\Requests\Settings;

use App\Enums\NotificationChannel;
use App\Enums\NotificationType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

final class UpdateNotificationRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $channels = array_column(NotificationChannel::cases(), 'value');
        $types = array_column(NotificationType::cases(), 'value');
        $rules = [
            '*' => ['required', 'array', Rule::in($channels)], // Validate top-level keys as NotificationChannel
        ];

        foreach ($channels as $channel) {
            $rules["$channel"] = ['required', 'array']; // Ensure it's an array
            foreach ($types as $type) {
                $rules["$channel.$type"] = ['required', 'boolean']; // Ensure values are boolean
            }
        }

        return $rules;
    }
}
