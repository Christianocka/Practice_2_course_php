<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Traits\ApiResponse;
use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;

class ToDoController extends Controller
{
    use ApiResponse;

    public function create(TaskCreateRequest $request)
    {
        $validatedData = $request->validated();

        $task = Task::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'is_done' => false,
            'priority' => $validatedData['priority'] ?? 1,
            'tags' => $validatedData['tags'] ?? [],
            'start_at' => $validatedData['start_at'] ?? null,
            'end_at' => $validatedData['end_at'] ?? null,
            'parent_id' => $validatedData['parent_id'] ?? null,
        ]);

        return $this->apiResponse(true, 'Задача добавлена', $task);
    }

    public function update(TaskUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();

        $task = Task::findOrFail(id: $id);
        $task->update($request->validated());
        $task->save();

        return $this->apiResponse(true, 'Задача обновлена', $task);
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->apiResponse(false, 'Задача не найдена', null, 404);
        }
        $task->delete();
        return $this->apiResponse(true, 'Задача удалена');
    }

    public function index(TaskCreateRequest $request)
    {
        $filters = $request->only(['start_at', 'end_at', 'tags', 'title']);

        $tasks = Task::with('children', 'files')
        ->filters($filters)
        ->get();

        return $this->apiResponse(true, 'Список задач', $tasks);
    }
}
