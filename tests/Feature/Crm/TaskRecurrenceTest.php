<?php

namespace Crm;

use App\Enums\Crm\RecurrenceType;
use App\Enums\Crm\TaskStatus;
use App\Models\Crm\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskRecurrenceTest extends TestCase
{
    use DatabaseTransactions;


    public function test_recurring_task_creates_copy_on_completion(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'is_recurring' => true,
            'recurrence_type' => RecurrenceType::Daily,
            'status' => TaskStatus::InProgress,
            'deadline' => now(),
        ]);

        $this->actingAs($user)
            ->patchJson("/api/tasks/{$task->id}/status", ['status' => TaskStatus::Done])
            ->assertOk();

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done']);

        $this->assertDatabaseHas('tasks', [
            'user_id' => $user->id,
            'status' => 'pending',
            'deadline' => $task->deadline->addDay()->toDateTimeString(),
        ]);
    }
}
