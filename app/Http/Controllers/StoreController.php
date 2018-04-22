<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\Create as CreateRequest;
use App\Http\Services\LogService;
use App\Http\Services\StoreService;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /** @var StoreService $storeService */
    private $storeService;
    /** @var LogService $logService */
    private $logService;

    /**
     * StoreController constructor.
     * @param StoreService $storeService
     * @param LogService $logService
     */
    public function __construct(StoreService $storeService, LogService $logService)
    {
        $this->storeService = $storeService;
        $this->logService = $logService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => [
            'stores' => $this->storeService->getUserStores()
        ]]);
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $storeId = $this->storeService->createStore($request->name);

            $this->logService->log(Auth::user()->graph_id, Log::CREATE_STORE, json_encode([
                'store_id' => $storeId,
                'ip' => request()->ip()
            ]));
        });

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
