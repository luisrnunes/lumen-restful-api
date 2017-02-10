<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityValidationException;
use App\Model\Entities\Address;
use App\Model\Entities\Customer;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function create(Request $request, $customerId) {
        $customer = Customer::findOrFail($customerId);
        $address  = new Address($request->all());
        if (!$address->isValid()) {
            throw new EntityValidationException($address);
        }

        $customer->addresses()->save($address);
        return response()->json(["message" => "Created."], 201);
    }
}