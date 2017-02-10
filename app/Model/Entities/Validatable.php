<?php

namespace App\Model\Entities;

interface Validatable
{
    public function getValidationErrors();
    public function isValid();
}