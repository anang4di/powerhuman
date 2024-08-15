<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $credentials = $request->only(['email', 'password']);

            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Unauthorized', 401);
            }

            $user = User::find(Auth::id());
            $token = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login success');

        } catch (Exception $e) {
            return ResponseFormatter::error('Authentication failed');
        }
    }

    public function register(Request $request) {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password(8)],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'company_id' => $request->input('company_id', 1),
            ]);

            $token = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Register success');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();

        return ResponseFormatter::success($token, 'Logout success');
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return ResponseFormatter::success($user, 'Get current user success');
    }
}
