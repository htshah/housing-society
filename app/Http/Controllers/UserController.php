<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use \App\Traits\JWTUtilTrait;
    private function setUserActiveStatus($id, $status)
    {
        $user = User::findOrFail($id);
        $user->is_active = $status;
        $user->save();

        return $user;
    }

    public function activateUser(Request $request)
    {
        try {
            $user = setUserActiveStatus($request->id, true);
            return ['success' => true, 'message' => "User activated successfully"];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function deactivateUser(Request $request)
    {
        try {
            $user = setUserActiveStatus($request->id, false);
            return ['success' => true, 'message' => "User deactivated successfully"];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }
    public function getAll(Request $request)
    {
        return ['success' => true, 'user' => User::all()];
    }

    public function get(Request $request)
    {
        try {
            return ['success' => true, 'user' => User::findOrFail($request->id)];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }
    }

    public function getCurrentUser(Request $request)
    {
        try {
            return ['success' => true, 'user' => User::findOrFail(static::getUserId())->first()];
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
            throw $e;
        }
    }

    public function update(Request $request)
    {
        $userId = static::getUserId();
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:user,email,' . $userId,
            'password' => 'nullable|string|between:6,30',
            'phone' => 'nullable|numeric|digits_between:10,13|unique:user,phone,' . $userId,
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        $input = $request->all();
        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }
        $user = null;

        try {
            $user = User::findOrFail($userId);
            $user->update($input);
            $user->save();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, 'user' => $user, 'message' => 'User updated successfully'];
    }

    public function delete(Request $request)
    {
        try {
            User::findOrFail($request->id)->delete();
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response(['success' => false, 'message' => 'Invalid ID'], 404);
            }
        }

        return ['success' => true, "message" => "Deleted User #{$request->id}"];
    }
}
