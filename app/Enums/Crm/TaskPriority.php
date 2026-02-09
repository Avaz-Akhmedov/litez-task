<?php

namespace App\Enums\Crm;

enum TaskPriority : string
{


    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
    case Critical = 'critical';
}
