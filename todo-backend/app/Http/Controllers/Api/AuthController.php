<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use DateInterval;
use DateTime;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email ou Senha não conferem.'], 401);
        }
        $user = User::firstWhere('email', $request->email);
        return $this->respondWithToken($token, $user);
    }

    public function refresh(Request $request)
    {
        $user = User::firstWhere('email', $request->email);
        return $this->respondWithToken(auth()->refresh(), $user);
    }

    protected function respondWithToken($token, $user)
    {
        $exp = new DateTime;
        $exp->add(new DateInterval('PT'.auth()->factory()->getTTL().'M'));
        return response()->json([
            'user' => $user,
            'token' => $token,
            'exp' => $exp
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
