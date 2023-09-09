<?php

namespace App\Http\Controllers\Api;

use App\Utils\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function getCredentials(Request $request)
    {
        if (is_numeric($request->input('username'))) {
            return ['phone_number' => $request->input('username'), 'password' => $request->input('password')];
        } elseif (filter_var($request->input('username'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->input('username'), 'password' => $request->input('password')];
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $credentials = $this->getCredentials($request);

        if ($token = auth('api')->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return Response::make(401, 'Unauthorized');
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();
        JWTAuth::invalidate(JWTAuth::getToken());

        return Response::make(200, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return Response::make(200, 'Loggin success', [
            'user' => auth('api')->user(),
            'token' => [
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'token_type' => 'bearer',
                'access_token' => $token,
            ],
        ]);
    }
}
