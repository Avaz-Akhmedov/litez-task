<?php

namespace App\Jobs\Crm;

use App\Models\Crm\Task;
use App\Services\Crm\TaskReminderService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendTaskReminder implements ShouldQueue
{
    use Queueable;

    public function __construct(public Task $task) {}


    public function handle(TaskReminderService $reminderService): void
    {
        $reminderService->sendReminder($this->task);
    }


    public function failed(\Throwable $exception): void
    {
        Log::error('Failed to send task reminder', [
            'task_id' => $this->task->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
