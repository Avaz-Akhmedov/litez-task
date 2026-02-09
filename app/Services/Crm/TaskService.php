<?php

namespace App\Services\Crm;

use App\DTOs\Crm\CreateTaskDTO;
use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskStatus;
use App\Models\Crm\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TaskService
{
    public function create(CreateTaskDTO $dto, User $user): Task
    {
        return $user->tasks()->create($dto->toArray() + ['status' => TaskStatus::Pending]);
    }

    /**
     * @throws ValidationException
     */
    public function updateStatus(Task $task, TaskStatus $newStatus)
    {
        if (!$task->status->canTransitionTo($newStatus)) {
            throw ValidationException::withMessages([
                'status' => ["Переход из {$task->status->value} в {$newStatus->value} невозможен"]
            ]);
        }

        return DB::transaction(function () use ($task, $newStatus) {

            $updateData = ['status' => $newStatus];

            if ($newStatus === TaskStatus::Done) {
                $updateData['completed_at'] = now();
                $this->handleRecurrence($task);
            }

            $task->update($updateData);

            return $task;
        });
    }


    private function handleRecurrence(Task $task): void
    {
        if (!$task->is_recurring || !$task->recurrence_type) {
            return;
        }

        $newDeadline = match ($task->recurrence_type) {
            RecurrenceType::Daily => Carbon::parse($task->deadline)->addDay(),
            RecurrenceType::Weekly => Carbon::parse($task->deadline)->addWeek()
        };

        $newTask = $task->replicate([
            'status',
            'completed_at',
            'reminder_sent_at',
            'created_at',
            'updated_at'
        ]);

        $newTask->status = TaskStatus::Pending;
        $newTask->deadline  = $newDeadline;

        $newTask->save();

    }
}
