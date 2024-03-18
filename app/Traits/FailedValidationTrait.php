<?php


namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;

trait FailedValidationTrait
{
    /**
    * Handle a failed validation attempt.
    *
    * @param  \Illuminate\Contracts\Validation\Validator  $validator
    * @return void
    *
    * @throws \Illuminate\Validation\ValidationException
    */
    protected function failedValidation(Validator $validator)
    {
        $exception = $validator->getException();
        throw (new $exception($validator))
                    ->errorBag($this->errorBag)->status(400)
                    ->redirectTo($this->getRedirectUrl());
    }
}
