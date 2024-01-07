<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();


    if ($user) {
        // If a valid user is authenticated, log them out
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json(['message' => 'logged out successfully']);
    }

    return response()->json(['message' => 'Token autentication failed']);
    }

    public function getCurrentDateTime(Request $request)
    {


        return response()->json(['current_datetime' => now()]);
    }
}
?>
