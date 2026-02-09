<?php

namespace App\Filters\Crm;

use Illuminate\Database\Eloquent\Builder;

class TaskFilter
{
    public function apply(Builder $query, array $filters)
    {
        return $query
            ->when($filters['type'] ?? null, fn($q, $type) => $q->where('type', $type))
            ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['client_id'] ?? null, fn($q, $clientId) => $q->where('client_id', $clientId))
            ->when($filters['date_from'] ?? null, fn($q, $date) => $q->whereDate('created_at', '>=', $date))
            ->when($filters['date_to'] ?? null, fn($q, $date) => $q->whereDate('created_at', '<=', $date));
    }
}
