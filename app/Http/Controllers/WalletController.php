<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\Create as CreateRequest;
use App\Http\Services\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    /** @var WalletService $walletService */
    private $walletService;

    /**
     * WalletController constructor.
     * @param WalletService $walletService
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * @param CreateRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(CreateRequest $request): JsonResponse
    {
        $this->walletService->createWallet($request->name);

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }
}
