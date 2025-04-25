<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponse;

    public function register(Request $request)
    {   
        try {
            // $validated = $request->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(
                ['user' => $user, 'token' => $token],
                'User registered successfully',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Registration failed',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    public function login(Request $request)
    {
        try {
            $validated = $request->validated();


            $user = User::where('email', $request->email)->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;

            return $this->successResponse(
                ['user' => $user, 'token' => $token],
                'Logged in successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Login failed',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return $this->successResponse(
                null,
                'Logged out successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Logout failed',
                ['error' => $e->getMessage()],
                500
            );
        }
    }

    public function user()
    {
        try {
            return $this->successResponse(
                auth()->user(),
                'User details retrieved successfully'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to retrieve user details',
                ['error' => $e->getMessage()],
                500
            );
        }
    }
} 