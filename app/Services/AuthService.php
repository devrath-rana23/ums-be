<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

/**
 * Class AuthService handles the authentication actions.
 **/

class AuthService
{
    /**
     * Returns Google login url.
     *
     */
    public function auth()
    {
        /** @var GoogleProvider $socialite */
        $socialite = Socialite::driver('google');

        return response()->json([
            'url' => $socialite
                ->stateless()
                ->redirect()
                ->getTargetUrl(),
        ]);
    }
    /**
     * Handles the Google callback.
     *
     */
    public function callback()
    {
        try {
            /** @var GoogleProvider $socialite */
            $socialite = Socialite::driver('google');
            $socialiteUser = $socialite->stateless()->user();
        } catch (Exception $err) {
            response()->json([
                'code' => $err,
                'message' => 'Invalid credentials'
            ]);
        }
        if ($socialiteUser === null) {
            return response()->json([
                'message' => 'Google user is null.'
            ], 404);
        }
        $userData = collect($socialiteUser->getRaw());
        $user = User::where([['email', '=', $userData->get('email')], ['status', '=', 1]])->first();
        if (!empty($user->email) && is_null($user->google_id)) {
            User::where('email', $user->email)->update(['google_id' => $socialiteUser->getId()]);
        }
        if (!$user) {
            return response()->json([
                'message' => 'Record not found.'
            ], 404);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'   =>     $user
        ]);
    }
}
