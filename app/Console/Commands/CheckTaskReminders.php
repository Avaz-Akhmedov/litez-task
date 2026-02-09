<?php

namespace App\Console\Commands;

use App\Enums\Crm\TaskStatus;
use App\Jobs\Crm\SendTaskReminder;
use App\Models\Crm\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckTaskReminders extends Command
{
    protected $signature = 'tasks:check-reminders';
    protected $description = 'Dispatch job for the tasks that are about to end';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $tasks = Task::query()
            ->whereNull('reminder_sent_at')
            ->whereNotNull('remind_before_minutes')
            ->whereNotIn('status', [
                TaskStatus::Done,
                TaskStatus::Cancelled
            ])
            ->get()
            ->filter(function ($task) {
                $remindAt = $task->deadline->subMinutes($task->remind_before_minutes);
                return $remindAt->lte(now());
            });

        foreach ($tasks as $task) {
            SendTaskReminder::dispatch($task);
        }

        $overdueCount = Task::overdue()->count();
        if ($overdueCount > 0) {
            Log::warning("Found {$overdueCount} overdue tasks at " . now());
        }
    }
}
