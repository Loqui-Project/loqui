<?php

namespace App\Http\Requests\API\Auth;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }

    public function getInput()
    {
        return $this->only(['name', 'username', 'email', 'password']);
    }


}
