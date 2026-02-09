<?php

namespace Crm;

use App\Enums\Crm\TaskStatus;
use PHPUnit\Framework\TestCase;

class TaskStatusTest extends TestCase
{
    public function test_cannot_transition_from_done_to_pending(): void
    {
        $status = TaskStatus::Done;
        $this->assertFalse($status->canTransitionTo(TaskStatus::Pending));
    }

    public function test_can_transition_from_pending_to_progress(): void
    {
        $status = TaskStatus::Pending;
        $this->assertTrue($status->canTransitionTo(TaskStatus::InProgress));
    }
}
