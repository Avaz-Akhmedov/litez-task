<?php

namespace App\Models\Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskPriority;
use App\Enums\Crm\TaskStatus;
use App\Enums\Crm\TaskType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static Builder overdue()
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'type',
        'title',
        'description',
        'priority',
        'status',
        'deadline',
        'is_recurring',
        'recurrence_type',
        'remind_before_minutes',
        'remind_via',
        'reminder_sent_at',
        'completed_at',
    ];

    protected $casts = [
        'type' => TaskType::class,
        'priority' => TaskPriority::class,
        'status' => TaskStatus::class,
        'recurrence_type' => RecurrenceType::class,

        'is_recurring' => 'boolean',
        'deadline' => 'datetime',
        'reminder_sent_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function scopeOverdue(Builder $query)
    {
        return $query
            ->whereNotIn('status', [
                TaskStatus::Done->value,
                TaskStatus::Cancelled->value,
            ])
            ->where('deadline', '<', now());
    }
}
