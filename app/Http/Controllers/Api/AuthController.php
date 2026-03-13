<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\PasswordChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'identifier' => ['required'], // can be username or email
            'password' => ['required'],
        ]);

        // Determine login type
        $loginType = filter_var($request->identifier, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Attempt authentication
        $credentials = [
            $loginType => $request->identifier,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout(); // Clear session just in case

            return response()->json([
                'message' => 'Your account is inactive. Please contact support.'
            ], 403);
        }

        // Create Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => __($status)
            ]);
        }

        return response()->json([
            'message' => __($status)
        ], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));

                // Send notification email
                $user->notify(new PasswordChanged());
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => __($status)
            ]);
        }

        return response()->json([
            'message' => __($status)
        ], 400);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Current password is incorrect'
            ], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Fire Laravel PasswordReset event (optional but keeps consistency)
        event(new PasswordReset($user));

        // Notify user via email
        $user->notify(new PasswordChanged());

        return response()->json([
            'message' => 'Password changed successfully. An email notification has been sent.'
        ]);
    }
}