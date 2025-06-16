<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(TodoList $todoList)
    {
        $this->authorize('view', $todoList);

        $tasks = $todoList->tasks;
        return response()->json($tasks);
    }

    public function store(Request $request, TodoList $todoList)
    {
        $this->authorize('update', $todoList);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task = $todoList->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $task
        ], 201);
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task->todoList);

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task->todoList);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $task->update($request->only(['title', 'description', 'completed']));

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $task
        ]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task->todoList);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully'
        ]);
    }
}