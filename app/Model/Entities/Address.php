<?php

namespace App\Model\Entities;

use Illuminate\Database\Eloquent\Model;

class Address extends Model implements Validatable
{
    protected $validationErrors;

    protected $rules = [
        "street"       => "required",
        "number"       => "required",
        "zip_code"     => "required|digits:8",
        "neighborhood" => "required",
        "city"  => "required",
        "state" => "required|max:2"
    ];

    protected $fillable = [
        "street", "number", "zip_code",
        "neighborhood", "city", "state"
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
     * Get the customer who is the owner of the address
     */
    public function customer() {
        return $this->belongsTo('App\Model\Entities\Customer');
    }
}