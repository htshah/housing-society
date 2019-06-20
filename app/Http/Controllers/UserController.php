<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use JWTAuthException;
use JWTFactory;

class UserController extends Controller
{
    private function getToken($user)
    {
        $token = null;
        try {
            $payload = JWTFactory::sub($user->role)->user($user->toArray())->make();
            $token = JWTAuth::encode($payload);
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'Token creation failed',
            ]);
        }
        return (string) $token;
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = self::getToken($user);
            $response = ['success' => true, 'data' => ['id' => $user->id, 'token' => $token, 'name' => $user->name, 'email' => $user->email]];
        } else {
            $response = ['success' => false, 'data' => 'Invalid Credentials'];
        }

        return response()->json($response, 201)->cookie('token', $token, config('jwt.ttl'), "/", null, false, true);
    }

    public function register(Request $request)
    {
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
