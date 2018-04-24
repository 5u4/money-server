<?php

namespace App\Http\Controllers;

use App\Http\Services\AuthService;
use App\Http\Services\LogService;
use App\Http\Services\ServiceService;
use App\Http\Services\StoreService;
use App\Http\Services\TransactionService;
use App\Http\Requests\Transaction\Create as CreateRequest;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Auth;

class TransactionController extends Controller
{
    /** @var AuthService $authService */
    private $authService;
    /** @var StoreService $storeService */
    private $storeService;
    /** @var ServiceService $serviceService */
    private $serviceService;
    /** @var TransactionService $transactionService */
    private $transactionService;
    /**  @var LogService $logService */
    private $logService;

    /**
     * WalletController constructor.
     * @param AuthService $authService
     * @param StoreService $storeService
     * @param ServiceService $serviceService
     * @param TransactionService $transactionService
     * @param LogService $logService
     */
    public function __construct(
        AuthService $authService,
        StoreService $storeService,
        ServiceService $serviceService,
        TransactionService $transactionService,
        LogService $logService
    ) {
        $this->transactionService = $transactionService;
        $this->logService = $logService;
        $this->authService = $authService;
        $this->storeService = $storeService;
        $this->serviceService = $serviceService;
    }

    /**
     * Get current user's transactions
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => [
            'transactions' => $this->transactionService->getUserTransactions()
        ]]);
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $user = $this->authService->getCurrentUser();

        $transaction = $this->transactionService->createTransaction($request->amount, $request->wallet_id);

        /* Set Store */
        $storeId = $request->store_id;
        if ($storeId && $user->hasStore($storeId)) {
            $store = $this->storeService->getStore($storeId);
            $transaction->setStore($store);
        }

        /* Set Service */
        $serviceId = $request->service_id;
        if ($serviceId && $user->hasService($serviceId)) {
            $service = $this->serviceService->getService($serviceId);
            $transaction->setService($service);
        }

        $this->logService->log(Auth::user()->getGraphId(), Log::CREATE_TRANSACTION, json_encode([
            'transaction_id' => $transaction->getId(),
            'wallet_id' => $request->wallet_id,
            'store_id' => $request->store_id,
            'service_id' => $request->service_id,
            'ip' => request()->ip()
        ]));

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
