<?php

namespace App\Http\Requests\API\Auth;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    use FailedValidationTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'remmember' => 'nullable|boolean',
        ];
    }

    public function getInput()
    {
        return $this->only(['email', 'password']);
    }

    public function getRemember()
    {
        return $this->has('remember');
    }
}
