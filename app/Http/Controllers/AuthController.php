<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\Login as LoginRequest;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /** @var AuthService $authService */
    private $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Login user with credentials
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if ($access_token = $this->authService->login($request->name, $request->password)) {
            return response()->json(['data' => [
                'access_token' => $access_token
            ], 'success' => true], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Logout current user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        if ($currentUser = $this->authService->getCurrentUser()) {
            $this->authService->refreshToken();
            return response()->json([
                'success' => true
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
