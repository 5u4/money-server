<?php

namespace App\Http\Controllers;

use App\Http\Services\LogService;

class LogController extends Controller
{
    /** @var LogService $logService */
    private $logService;

    /**
     * LogController constructor.
     * @param LogService $logService
     */
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index()
    {
        return response()->json(['data' => [
            'logs' => $this->logService->getUserLogs()
        ]]);
    }
}
