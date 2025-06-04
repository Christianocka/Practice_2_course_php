<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest as TaskValidationRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class ToDoController extends Controller
{
    private function apiResponse($success, $message, $data = null, $status = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function create(TaskValidationRequest $request)
    {
        $validatedData = $request->validated();

        $task = Task::create([
            'task' => $validatedData['task'],
            'is_done' => false,
            'priority' => $validatedData['priority'] ?? 1,
            'category' => $validatedData['category'] ?? null,
            'tags' => $validatedData['tags'] ?? [],
            'start_at' => $validatedData['start_at'] ?? null,
            'end_at' => $validatedData['end_at'] ?? null,
        ]);

        dispatch(new \App\Models\Queue($task));

        return $this->apiResponse(true, 'Задача добавлена', $task);
    }

    public function update(TaskValidationRequest $request, $id)
    {
        $validatedData = $request->validated();

        $task = Task::findOrFail($id);
        $task->task = $validatedData['task'];
        $task->priority = $validatedData['priority'] ?? 1;
        $task->category = $validatedData['category'] ?? null;
        $task->tags = $validatedData['tags'] ?? [];
        $task->start_at = $validatedData['start_at'] ?? null;
        $task->end_at = $validatedData['end_at'] ?? null;
        $task->save();

        return $this->apiResponse(true, 'Задача обновлена', $task);
    }

    public function refresh(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return $this->apiResponse(false, 'Задача не найдена', null, 404);
        }

        $task->is_done = !$task->is_done;
        $task->save();

        return $this->apiResponse(true, 'Задача изменила статус', $task);
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

    public function index()
    {
        $tasks = Task::all();
        return $this->apiResponse(true, 'Список задач', $tasks);
    }
}
