<?php

namespace App\Http\Controllers;

use App\Http\Services\LogService;
use App\Http\Services\ServiceService;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Service\Create as CreateRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /** @var ServiceService $serviceService */
    private $serviceService;
    /** @var LogService $logService */
    private $logService;

    /**
     * StoreController constructor.
     * @param ServiceService $serviceService
     * @param LogService $logService
     */
    public function __construct(ServiceService $serviceService, LogService $logService)
    {
        $this->serviceService = $serviceService;
        $this->logService = $logService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => [
            'services' => $this->serviceService->getUserServices()
        ]]);
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     */
    public function create(CreateRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $serviceId = $this->serviceService->createService($request->name);

            $this->logService->log(Auth::user()->graph_id, Log::CREATE_SERVICE, json_encode([
                'service_id' => $serviceId,
                'ip' => request()->ip()
            ]));
        });

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
