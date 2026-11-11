<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class HealthController extends BaseApiController
{
    public function check(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            $dbStatus = 'connected';
        } catch (\Exception $e) {
            $dbStatus = 'disconnected';
        }

        return $this->successResponse([
            'status' => 'healthy',
            'app' => config('app.name'),
            'environment' => config('app.env'),
            'database' => $dbStatus,
            'realtime' => [
                'broadcaster' => config('broadcasting.default'),
                'reverb_host' => config('reverb.servers.reverb.host', '127.0.0.1'),
                'reverb_port' => config('reverb.servers.reverb.port', 8080),
            ],
            'timestamp' => now()->toISOString(),
        ], 'PlaceX API v1 is operational');
    }
}

