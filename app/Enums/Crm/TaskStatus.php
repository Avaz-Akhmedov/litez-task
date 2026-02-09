<?php

namespace App\Enums\Crm;

enum TaskStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Done = 'done';
    case Cancelled = 'cancelled';

    public function canTransitionTo(self $newStatus): bool
    {
        return match ($this) {
            self::Pending => in_array($newStatus, [self::InProgress, self::Cancelled]),
            self::InProgress => in_array($newStatus, [self::Done, self::Cancelled]),
            self::Done, self::Cancelled => false,
        };
    }
}
