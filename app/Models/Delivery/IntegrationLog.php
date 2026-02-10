<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    protected $fillable = [
        'service',
        'method',
        'url',
        'request_body',
        'response_body',
        'status_code',
        'duration_ms',
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'array',
    ];
}
