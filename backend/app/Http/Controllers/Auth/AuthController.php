<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticación
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // Usuario autenticado
        $user  = $request->user();
        $token = $user->createToken('api')->plainTextToken;

        // Respuesta con el token primero
        return response()->json([
            'token' => $token,
            'user'  => $user->load(['student', 'staff', 'roles']),
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->load(['student', 'staff', 'roles']),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
