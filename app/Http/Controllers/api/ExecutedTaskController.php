<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecutedTaskRequest;
use App\Models\ExecutedTask;
use Illuminate\Http\Request;

class ExecutedTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $executedTasks = ExecutedTask::where('task_id', $request->task_id)
            ->orderBy('date', 'desc')
            ->get();

        $response = $executedTasks->isEmpty() ? [] : $executedTasks;

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExecutedTaskRequest $request)
    {
        $executedTask = new ExecutedTask;
        $request->date =
            $executedTask->fill($request->all())->save();

        return response()->json($executedTask, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $executedTask = ExecutedTask::find($id);
        $executedTask->fill($request->all())->update();

        return response()->json($executedTask, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ExecutedTask::find($id)->delete();
        return response()->json(['id' => $id], 200);
    }
}