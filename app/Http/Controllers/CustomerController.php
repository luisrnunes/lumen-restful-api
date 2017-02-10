<?php

namespace App\Http\Controllers;

use App\Exceptions\EntityValidationException;
use App\Model\Entities\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAll() {
        $customerList = Customer::all();
        if (sizeof($customerList) <= 0) {
            $response = new \stdClass();
            $response->message = "Resource not found.";
            return response()->json($response, 404);
        }

        return response()->json($customerList, 200);
    }

    public function get($id) {
        return Customer::with("addresses")->findOrFail((int) $id);
    }

    public function create(Request $request) {
        $customer = new Customer($request->all());
        if (!$customer->isValid()) {
            throw new EntityValidationException($customer);
        }

        $customer->save();
        return response()->json(["message" => "Created."], 201);
    }

    public function update(Request $request, $id) {
        $customer = Customer::findOrFail((int) $id);
        $customer->fill($request->all());
        if (!$customer->isValid()) {
            throw new EntityValidationException($customer);
        }

        $customer->save();
        return response()->json(["message" => "Resource has been updated."], 200);
    }
}