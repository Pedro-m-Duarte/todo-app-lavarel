<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoListController extends Controller
{
    public function index()
    {
        $userId = auth('api')->id();
        $user = User::find($userId);
        $todoLists = $user->todoLists()->with('tasks')->get();

        return response()->json($todoLists);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = auth('api')->id();
        $user = User::find($userId);

        $todoList = $user->todoLists()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Todo list created successfully',
            'todo_list' => $todoList
        ], 201);
    }

    public function show(TodoList $todoList)
    {
        $this->authorize('view', $todoList);
        $todoList->load('tasks');
        return response()->json($todoList);
    }

    public function update(Request $request, TodoList $todoList)
    {
        $this->authorize('update', $todoList);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todoList->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Todo list updated successfully',
            'todo_list' => $todoList
        ]);
    }

    public function destroy(TodoList $todoList)
    {
        $this->authorize('delete', $todoList);

        $todoList->delete();

        return response()->json([
            'message' => 'Todo list deleted successfully'
        ]);
    }
}