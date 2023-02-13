<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }
    /**
     * @var string The name of the tag for the OpenAPI documentation.
     */

    /**
     * Returns the Google url.
     *
     * @return JsonResponse
     */

    public function index(): JsonResponse
    {
        return $this->service->auth();
    }

    /**
     * Handles the Google callback.
     *
     * @return JsonResponse
     */

    public function callback(): JsonResponse
    {
        return $this->service->callback();
    }
    /**
     * Logout the user and revoke the token.
     *
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'user logged out',
            'status'  => 200
        ]);
    }
}
