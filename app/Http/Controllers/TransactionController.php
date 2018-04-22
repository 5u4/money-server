<?php

namespace App\Http\Controllers;

use App\Http\Services\LogService;
use App\Http\Services\TransactionService;
use App\Http\Requests\Transaction\Create as CreateRequest;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /** @var TransactionService $transactionService */
    private $transactionService;
    /**  @var LogService $logService */
    private $logService;

    /**
     * WalletController constructor.
     * @param TransactionService $transactionService
     * @param LogService $logService
     */
    public function __construct(TransactionService $transactionService, LogService $logService)
    {
        $this->transactionService = $transactionService;
        $this->logService = $logService;
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
     */
    public function create(CreateRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $transactionId = $this->transactionService->createTransaction($request->amount, $request->wallet_id);

            if ($request->store_id) {
                $this->transactionService->transactionInStore($transactionId, $request->store_id);
            }

            if ($request->service_id) {
                $this->transactionService->transactionOnService($transactionId, $request->service_id);
            }

            $this->logService->log(Auth::user()->graph_id, Log::CREATE_TRANSACTION, json_encode([
                'transaction_id' => $transactionId,
                'wallet_id' => $request->wallet_id,
                'store_id' => $request->store_id,
                'service_id' => $request->service_id,
                'ip' => request()->ip()
            ]));
        });

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
