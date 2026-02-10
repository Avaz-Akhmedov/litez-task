<?php

namespace App\Services\Delivery;

use App\Models\Delivery\IntegrationLog;

class IntegrationLoggerService
{

    public function log(
        string $service,
        string $method,
        string $url,
        mixed  $request,
        mixed  $response,
        int    $statusCode,
        float  $startTime
    ): void
    {
        $duration = round((microtime(true) - $startTime) * 1000);

        IntegrationLog::query()->create([
            'service' => $service,
            'method' => $method,
            'url' => $url,
            'request_body' => json_encode($request),
            'response_body' => json_encode($response),
            'status_code' => $statusCode,
            'duration_ms' => (int)$duration,
        ]);
    }

}
