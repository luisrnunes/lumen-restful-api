<?php

namespace App\Model\Entities;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model implements Validatable
{
    protected $validationErrors;

    protected $rules = [
        "name"       => "required|min:3",
        "document"   => "required|digits:11",
        "birth_date" => "required|date_format:d/m/Y",
        "email"      => "required|email",
        "phone"      => "required|digits:13"
    ];

    protected $fillable = [
        "name", "document", "birth_date",
        "email", "phone"
    ];

    public function getValidationErrors() {
        return $this->validationErrors;
    }

    public function isValid() {
        $validator = \Validator::make($this->attributes, $this->rules);
        if (!$validator->passes()) {
            $this->validationErrors = $validator->errors()->all();
            return false;
        }

        return true;
    }

    /**
     * Get the addresses for the customer
     */
    public function addresses() {
        return $this->hasMany('App\Model\Entities\Address');
    }
}