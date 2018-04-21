<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Create as CreateRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /** @var UserService $userService */
    private $userService;
    /** @var AuthService $authService */
    private $authService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param AuthService $authService
     */
    public function __construct(UserService $userService, AuthService $authService)
    {
        $this->userService = $userService;
        $this->authService = $authService;
    }

    /**
     * Create a user
     *
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(CreateRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $neoUser = $this->userService->getNeoUser($request->name);

            $this->userService->createUserInRDB(
                $neoUser->getId(),
                $request->name,
                $request->email,
                $request->password
            );
        });

        return response()->json([
            'success' => true
        ], Response::HTTP_CREATED);
    }

    /**
     * Soft delete current user
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        if ($user = $this->authService->getCurrentUser()) {
            $user->delete();
            return response()->json([
                'success' => true
            ], Response::HTTP_OK);
        }

        return response()->json([
            'success' => false
        ], Response::HTTP_BAD_REQUEST);
    }
}
