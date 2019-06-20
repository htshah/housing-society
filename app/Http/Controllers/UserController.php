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
            $payload = JWTFactory::sub($user->id)->user($user->toArray())->make();
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
            $response = ['success' => true, 'data' => ['id' => $user->id, 'auth_token' => $token, 'name' => $user->name, 'email' => $user->email]];
        } else {
            $response = ['success' => false, 'data' => 'Invalid Credentials'];
        }

        return response()->json($response, 201)->cookie('auth_token', $token);
    }

    public function register(Request $request)
    {
        $payload = [
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'name' => $request->name,
            'auth_token' => '',
        ];

        $user = new \App\User($payload);
        if ($user->save()) {

            $token = self::getToken($request->email, $request->password); // generate user token

            if (!is_string($token)) {
                return response()->json(['success' => false, 'data' => 'Token generation failed'], 201);
            }

            $user = \App\User::where('email', $request->email)->get()->first();

            $user->auth_token = $token; // update user token

            $user->save();

            $response = ['success' => true, 'data' => ['name' => $user->name, 'id' => $user->id, 'email' => $request->email, 'auth_token' => $token]];
        } else {
            $response = ['success' => false, 'data' => 'Couldnt register user'];
        }

        return response()->json($response, 201);
    }
}
