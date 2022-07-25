<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::select(
            'tasks.id',
            'users.name as user_name',
            'tasks.name as task_name',
            'tasks.purpose',
            'tasks.action',
            'tasks.target_times',
            'tasks.times_unit',
            'tasks.schedule_start',
            'tasks.schedule_end',
            'tasks.remarks',
            'tasks.status',
            'tasks.user_id'
        )
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->orderby('id', 'desc')
            ->get();

        $response = $tasks->isEmpty() ? [] : $tasks;
        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task;
        $task->fill($request->all())->save();

        $stored = Task::select(
            'tasks.id',
            'users.name as user_name',
            'tasks.name as task_name',
            'tasks.purpose',
            'tasks.action',
            'tasks.target_times',
            'tasks.times_unit',
            'tasks.schedule_start',
            'tasks.schedule_end',
            'tasks.remarks',
            'tasks.status',
            'tasks.user_id'
        )
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->orderByDesc('tasks.id')
            ->first();

        return response()->json($stored, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, $id)
    {
        $post = Task::find($id);

        $post->fill($request->all())->update();

        $updated = Task::select(
            'tasks.id',
            'users.name as user_name',
            'tasks.name as task_name',
            'tasks.purpose',
            'tasks.action',
            'tasks.target_times',
            'tasks.times_unit',
            'tasks.schedule_start',
            'tasks.schedule_end',
            'tasks.remarks',
            'tasks.status',
            'tasks.user_id'
        )
            ->join('users', 'users.id', '=', 'tasks.user_id')
            ->where('tasks.id', $id)
            ->get();

        return response()->json($updated, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::find($id)->delete();
        return response()->json(['id' => $id], 200);
    }
}