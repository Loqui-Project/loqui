<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;

trait FailedValidationTrait
{
    /**
     * Handle a failed validation attempt.
     *
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): never
    {
        $exception = $validator->getException();
        throw (new $exception($validator))
            ->errorBag($this->errorBag)->status(400)
            ->redirectTo($this->getRedirectUrl());
    }
}
