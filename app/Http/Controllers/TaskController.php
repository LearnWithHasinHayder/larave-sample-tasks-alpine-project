<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the user's tasks
     */
    public function index(Request $request)
    {
        $tasks = $request->user()
            ->tasks()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'tasks' => $tasks,
        ]);
    }

    /**
     * Store a newly created task
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'is_completed' => false,
        ]);

        return response()->json([
            'message' => 'Task created successfully! 🎯',
            'task' => $task,
        ], 201);
    }

    /**
     * Display the specified task
     */
    public function show(Request $request, Task $task)
    {
        // Ensure user owns the task
        if ($task->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        return response()->json([
            'task' => $task,
        ]);
    }

    /**
     * Update the specified task
     */
    public function update(Request $request, Task $task)
    {
        // Ensure user owns the task
        if ($task->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'sometimes|boolean',
        ]);

        $task->update($request->only(['title', 'description', 'is_completed']));

        return response()->json([
            'message' => 'Task updated successfully! ✅',
            'task' => $task,
        ]);
    }

    /**
     * Remove the specified task
     */
    public function destroy(Request $request, Task $task)
    {
        // Ensure user owns the task
        if ($task->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully! 🗑️',
        ]);
    }
}

