<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface AuthModelFactoryInterface
{
    public function make(array $attributes = []): Model;

    public function create(array $attributes = []): Model;

    public function getClass(): string;
}
