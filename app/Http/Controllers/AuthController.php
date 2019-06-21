<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use JWTAuthException;
use JWTFactory;

class AuthController extends Controller
{
    private function getToken($user)
    {
        $token = null;
        try {
            $payload = JWTFactory::sub($user->role)->user($user->toArray())->make();
            $token = JWTAuth::encode($payload);
        } catch (JWTAuthException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token creation failed',
            ]);
        }
        return (string) $token;
    }

    public function login(Request $request)
    {
        $response = [];
        $token = '';
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|between:6,30',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        $user = User::where('email', $request->email)->get()->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Check if user is activated or not
            if (!$user->is_active) {
                return [
                    'success' => false,
                    'message' => 'User is not activated.',
                ];
            }
            $token = self::getToken($user);
            $response = ['success' => true, 'data' => ['id' => $user->id, 'token' => $token, 'name' => $user->name, 'email' => $user->email]];
        } else {
            $response = ['success' => false, 'message' => 'Invalid Credentials'];
        }

        return response()->json($response, 201)->cookie('token', $token, config('jwt.ttl'), "/", null, false, false);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|between:6,30',
            'phone' => 'required|numeric|digits_between:10,13|unique:user,phone',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }
        $input = [
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
            'name' => $request->name,
        ];

        // TODO Validation

        $user = new \App\User($input);
        if ($user->save()) {

            $response = ['success' => true, 'data' => [
                'message' => 'Registered successfully',
            ]];
        } else {
            $response = ['success' => false, 'data' => 'Couldnt register user'];
        }

        return response()->json($response, 201);
    }
}
