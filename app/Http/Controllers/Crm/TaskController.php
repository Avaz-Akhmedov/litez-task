<?php

namespace App\Http\Controllers\Crm;

use App\DTOs\Crm\CreateTaskDTO;
use App\DTOs\Crm\UpdateTaskDTO;
use App\Enums\Crm\TaskStatus;
use App\Filters\Crm\TaskFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Crm\StoreTaskRequest;
use App\Http\Requests\Crm\TaskFilterRequest;
use App\Http\Requests\Crm\UpdateTaskRequest;
use App\Http\Requests\Crm\UpdateTaskStatusRequest;
use App\Http\Resources\Crm\TaskResource;
use App\Models\Crm\Task;
use App\Services\Crm\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
    }

    public function index(TaskFilterRequest $request, TaskFilter $filter): AnonymousResourceCollection
    {

        $tasks = Task::query()
            ->with(['client', 'user'])
            ->latest()
            ->tap(fn($query) => $filter->apply($query, $request->validated()))
            ->paginate(16);

        return TaskResource::collection($tasks);
    }


    public function today(Request $request): AnonymousResourceCollection
    {
        $tasks = Task::query()
            ->whereDate('deadline', now()->toDateString())
            ->with(['client', 'user'])
            ->get();

        return TaskResource::collection($tasks);
    }

    public function overdue(Request $request): AnonymousResourceCollection
    {
        $tasks = Task::overdue()->with(['client', 'user'])->get();
        return TaskResource::collection($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create
        (
            CreateTaskDTO::fromRequest($request),
            $request->user()
        );

        return response()->json([
            'success' => true,
            'task' => TaskResource::make($task->load(['client', 'user']))
        ], 201);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $dto = UpdateTaskDTO::fromRequest($request);
        $task->update($dto->toArray());


        $task->refresh();

        return response()->json([
            'success' => true,
            'task' => TaskResource::make($task->load(['client', 'user']))
        ]);
    }

    /**
     * @throws ValidationException
     */
    public function updateStatus(UpdateTaskStatusRequest $request, Task $task): JsonResponse
    {

        $updatedTaskStatus = $this->taskService->updateStatus
        (
            $task,
            TaskStatus::from($request->validated('status'))
        );

        return response()->json([
            'success' => true,
            'task' => TaskResource::make($updatedTaskStatus->load(['client', 'user']))
        ]);
    }

    public function destroy(Task $task): Response
    {
        $task->delete();

        return response()->noContent();
    }
}
