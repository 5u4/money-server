<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Http\Services\LogService;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\Login as LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /** @var AuthService $authService */
    private $authService;
    /** * @var LogService $logService */
    private $logService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     * @param LogService $logService
     */
    public function __construct(AuthService $authService, LogService $logService)
    {
        $this->authService = $authService;
        $this->logService = $logService;
    }

    /**
     * Login user with credentials
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $userGraphId = $this->authService->getUserGraphIdByEmail($request->email);

        /* Login Successfully */
        if ($access_token = $this->authService->login($request->email, $request->password)) {
            $this->logService->log($userGraphId, Log::LOGIN, json_encode([
                'success' => true,
                'ip' => request()->ip()
            ]));

            $this->authService->getCurrentUser()->ip = request()->ip();

            return response()->json(['data' => [
                'access_token' => $access_token
            ], 'success' => true], Response::HTTP_OK);
        }

        /* Wrong Credentials */
        else {
            $this->logService->log($userGraphId, Log::LOGIN, json_encode([
                'success' => false,
                'ip' => request()->ip()
            ]));

            return response()->json([
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Logout current user
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function logout(): JsonResponse
    {
        /* Logout User */
        if ($currentUser = $this->authService->getCurrentUser()) {
            DB::transaction(function () use ($currentUser) {
                $this->authService->refreshToken();
                $this->logService->log($currentUser->graph_id, Log::LOGOUT, json_encode([
                    'ip' => request()->ip()
                ]));
            });

            return response()->json([
                'success' => true
            ], Response::HTTP_OK);
        }

        /* Cannot Get User */
        else {
            return response()->json([
                'success' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
