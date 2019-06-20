<?php

namespace App\Http\Controllers;

use App\Billing;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    use \App\Traits\JWTUtilTrait;

    public function getAll(Request $request)
    {
        return ['success' => true, 'bill' => Billing::all()];
    }

    public function getUserBill(Request $request)
    {
        return ['success' => true, 'bill' => User::findOrFail(static::getUserId())->bills];
    }

    public function get(Request $request)
    {
        try {
            $bill = static::isUserAdmin()
            ? Billing::findOrFail($request->id)
            : User::findOrFail(static::getUserId())->bills()->findOrFail($request->id);

            return ['success' => true, 'bill' => $bill];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function create(Request $request)
    {
        $bill = new bill;
        $bill->fill($request->all());
        $bill->save();

        return response()->json(['success' => true, 'bill' => $bill]);
    }

    public function pay(Request $request)
    {
        $bill = null;
        try {
            $bill = User::findOrFail(static::getUserId())->bills()->findOrFail($request->id);
            $bill->is_payed = true;
            $bill->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return response()->json(['success' => true, 'bill' => $bill]);
    }

    public function update(Request $request)
    {
        $billing = null;
        try {
            $billing = Billing::findOrFail($request->id);
            $billing->update($request->all());
            $billing->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return response()->json(['success' => true, 'message' => 'Bill updated successfully', 'bill' => $billing->toArray()]);
    }

    public function delete(Request $request)
    {
        try {
            Billing::findOrFail($request->id)->delete();
            return [
                'success' => true,
                "message" => "Deleted Bill #{$request->id}",
            ];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }
}
