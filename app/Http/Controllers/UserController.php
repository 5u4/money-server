<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Create as CreateRequest;
use App\Http\Services\LogService;
use App\Http\Services\UserService;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /** @var UserService $userService */
    private $userService;
    /** @var LogService $logService */
    private $logService;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param LogService $logService
     */
    public function __construct(UserService $userService, LogService $logService)
    {
        $this->userService = $userService;
        $this->logService = $logService;
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
            $neoUser = $this->userService->createNeoUser($request->name);

            $this->userService->createUserInRDB(
                $neoUser->getId(),
                $request->name,
                $request->email,
                $request->password
            );

            $this->logService->log($neoUser->getId(), Log::CREATE_USER, json_encode([
                'name' => $request->name,
                'email' => $request->email,
                'ip' => request()->ip()
            ]));
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
        $success = DB::transaction(function () {
            $success = $this->userService->softDeleteCurrentUser();

            $this->logService->log(Auth::user()->graph_id, Log::DELETE_USER, json_encode([
                'ip' => request()->ip()
            ]));

            return $success;
        });

        return response()->json(['success' => $success]);
    }
}
