<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        return Task::with('category')->paginate(10);
    }

    public function store(Request $request)
    {
        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    public function show(Task $task)
    {
        return $task;
    }

    // public function update(Request $request, $id)
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_id' => 'nullable|integer', // Adjust validation as needed
            'title' => 'nullable|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean', // Adjust validation as needed
            'due_date' => 'nullable|date', // Adjust validation as needed
        ]);

        try {
            // Find the task by ID or fail
            $task = Task::findOrFail($id);

            // Update the task with validated data
            $task->update($validatedData);

            // Return the updated task
            return response()->json($task, 200);
        } catch (\Exception $e) {
            // Log and return error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $re = Task::withTrashed()->find($id);
        if ($re) {
            $re->restore();
            return response()->json($re, 200);
        }else{
            return response()->json($re, 500);

        }
    }
}
