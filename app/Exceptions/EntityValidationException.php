<?php

namespace App\Exceptions;

use App\Model\Entities\Validatable;

class EntityValidationException extends \Exception
{
    protected $message = "Validation failed.";
    private $invalidEntity;

    public function __construct(Validatable $invalidEntity) {
        $this->invalidEntity = $invalidEntity;
        parent::__construct();
    }

    public function getValidationErrors() {
        return $this->invalidEntity->getValidationErrors();
    }
}