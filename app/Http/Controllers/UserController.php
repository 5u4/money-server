<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Create as CreateRequest;
use App\Http\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /** @var UserService $userService */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
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
        $success = $this->userService->softDeleteCurrentUser();

        return response()->json(['success' => $success]);
    }
}
