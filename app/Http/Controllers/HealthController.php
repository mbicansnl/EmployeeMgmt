<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController
{
    public function __invoke(): JsonResponse
    {
        $db = DB::connection()->getPdo() ? 'ok' : 'error';

        return response()->json([
            'status' => 'ok',
            'db' => $db,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
