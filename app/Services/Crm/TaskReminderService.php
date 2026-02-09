<?php

namespace App\Services\Crm;

use App\Models\Crm\Task;
use App\Notifications\TaskReminderNotification;
use Illuminate\Support\Facades\Log;

class TaskReminderService
{

    public function sendReminder(Task $task): void
    {
        match ($task->remind_via) {
            'email' => $this->sendEmailReminder($task),
            'sms' => $this->sendSmsReminder($task),
            default => throw new \InvalidArgumentException("Unsupported remind_via: {$task->remind_via}"),
        };

        $task->update(['reminder_sent_at' => now()]);
    }

    private function sendEmailReminder(Task $task): void
    {
        $task->user->notify(new TaskReminderNotification($task));
    }

    private function sendSmsReminder(Task $task): void
    {

        Log::info('SMS reminder sent', [
            'task_id' => $task->id,
            'user_phone' => $task->user?->phone,
        ]);
    }

}
