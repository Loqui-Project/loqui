<?php

namespace App\Http\Requests\API\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'username' => ['string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'media_object_id' => ['required', 'max:1024', 'exists:media_objects,id'],
        ];
    }

    public function getInput()
    {
        return $this->only(['name', 'email', 'username', 'media_object_id']);
    }
}
