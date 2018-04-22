<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\Create as CreateRequest;
use App\Http\Services\LogService;
use App\Http\Services\WalletService;
use App\Models\Neo\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /** @var WalletService $walletService */
    private $walletService;
    /**  @var LogService $logService */
    private $logService;

    /**
     * WalletController constructor.
     * @param WalletService $walletService
     * @param LogService $logService
     */
    public function __construct(WalletService $walletService, LogService $logService)
    {
        $this->walletService = $walletService;
        $this->logService = $logService;
    }

    /**
     * Get current user's wallets
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => [
            'wallets' => $this->walletService->getUserWallets()
        ]]);
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(CreateRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $walletId = $this->walletService->createWallet($request->name, $request->balance);

            $this->logService->log(Auth::user()->graph_id, Log::CREATE_WALLET, json_encode([
                'wallet_id' => $walletId,
                'ip' => request()->ip()
            ]));
        });

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
