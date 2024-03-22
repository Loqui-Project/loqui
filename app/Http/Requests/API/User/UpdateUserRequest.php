<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$this->user()->id,
            'username' => 'required|string|unique:users,username,'.$this->user()->id,
            'password' => 'required|string|min:8|confirmed',
            'media_object_id' => 'nullable|exists:media,id',
        ];
    }

    public function getInput()
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'media_object_id' => $this->media_object_id,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];
    }
}
