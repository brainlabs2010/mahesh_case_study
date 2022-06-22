<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repository\User\UserContract;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    private UserContract $userContract;

    /**
     * @param  UserContract  $userContract
     */
    public function __construct(UserContract $userContract)
    {
        $this->userContract = $userContract;
    }

    /**
     * Authenticate user.
     *
     * @param  LoginRequest  $request
     * @return JsonResponse|mixed
     */
    public function login(LoginRequest $request): mixed
    {
        try {
            $data = [
                'message' => "You are successfully logged in!",
                'data'    => $this->userContract->login($request->email, $request->password),
            ];

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Logout given user.
     *
     * @return JsonResponse|mixed
     */
    public function logout(): mixed
    {
        try {
            request()->user()->currentAccessToken()->delete();
            return $this->successResponse([
                'message' => "You are successfully logged out.",
            ]);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }

    /**
     * Register new user.
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse|mixed
     */
    public function register(RegisterRequest $request): mixed
    {
        try {
            return $this->successResponse([
                'message' => "You are successfully registered with us.",
                'data'    => $this->userContract->create($request->all()),
            ]);
        } catch (Exception $e) {
            return $this->errorMessage($e);
        }
    }
}
