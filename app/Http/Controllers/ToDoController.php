<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class ToDoController extends Controller
{
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'task' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        $task = Task::create([
            'task' => $validatedData['task'],
            'is_done' => false,
        ]);
        return response()->json([
            'message' => 'Задача добавлена', 
            'task' => $task
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'new_task' => ['required', 'string', 'min:1', 'max:255'],
        ]);

        $task = Task::findOrFail($id);
        $task->task = $validatedData['new_task'];
        $task->save();

        return response()->json([
            'message' => 'Задача обновлена', 
            'task' => $task
        ]);
    }

    public function refresh(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'message' => 'Задача не найдена'
            ], 
                404
            );
        }

        $task->is_done = !$task->is_done;
        $task->save();

        return response()->json([
            'message' => 'Задача изменила статус', 
            'is_done' => $task
        ]);
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json([
                'message' => 'Задача не найдена'
            ], 
                404
            );
        }
        $task->delete();
        return response()->json([
            'message' => 'Задача удалена'
        ]);
    }

    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'tasks' => $tasks
        ]);
    }
}
