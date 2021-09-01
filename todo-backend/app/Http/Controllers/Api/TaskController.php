<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Task;
use DateTime;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('status', 'ASC')
            ->orderBy('updated_at', 'ASC')
            ->get();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validationRules = [
            'name' => ['required']
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $task = Task::create(['name' => $request->name]);
        return response()->json($task);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 400);
        }
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 400);
        }

        $validationRules = [
            'name' => ['sometimes', 'required'],
            'status' => ['sometimes', 'required', 'boolean']
        ];
        $validator = Validator::make($request->all(), $validationRules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        if ($request->status) {
            $task->completed_at = date("Y-m-d H:i:s");
        } else {
            $task->completed_at = null;
        }

        $task->update([
            'name' => $request->name ? $request->name : $task->name,
            'status' => $request->status
        ]);
        return response()->json($task);
    }

    public function destroy($id)
    {
        $affectedRows = Task::destroy($id);
        if (!$affectedRows) {
            return response()->json(['error' => 'Tarefa não encontrada.'], 400);
        }
        return response()->json('Tarefa deletada.', 200);
    }
}
