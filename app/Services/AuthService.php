<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\ContactInfo;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\InvalidStateException;

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
        } catch (InvalidStateException $err) {
            return response()->json([
                'code' => $err,
                'status' => 404,
                'message' => 'Invalid credentials'
            ]);
        }
        if ($socialiteUser === null) {
            return response()->json([
                'status' => 404,
                'message' => 'Google user is null.'
            ], 404);
        }
        $userData = collect($socialiteUser->getRaw());
        $contact = ContactInfo::where('email', '=', $userData->get('email'))->first();
        $employee = $contact->employee;
        $user = $employee->user;
        if (!empty($contact->email) && is_null($user->google_id)) {
            $user->google_id = $socialiteUser->getId();
            $user->save();
        }
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Record not found.'
            ], 404);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'   =>     $user,
            'status' => 200,
        ]);
    }
}
