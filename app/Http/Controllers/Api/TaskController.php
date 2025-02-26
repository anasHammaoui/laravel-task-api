<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task as ModelsTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // all tasks
    public function index(){
        $tasks = ModelsTask::where('user_id',auth() ->user() -> id) -> get();
        if ($tasks -> count() > 0){
            return TaskResource::collection($tasks);
        } else {
            return response() -> json([ 'message' => "Il y'a aucune task pour vous"],200);
        }
    }
    // // create a task
    public function store(Request $request){
        $validate = $request -> validate([
            'title' => 'required|min:4',
            'due_date' => 'required',
        ]);
        $task = ModelsTask::create([
            'title' => $validate['title'],
            'due_date' => $validate['due_date'],
            'user_id' => auth('api') -> user() -> id
           ]
        );
        $task = ModelsTask::find($task -> id);
        if ($task){
            return response()-> json([
                'message' => 'success',
                'task' => $task,
            ],200);
        } else {
            return response()-> json([
                'message' => 'error',
            ],404);
        }
    }
    // // update a task
    public function show($id){
        $task = ModelsTask::where('id',$id) -> get();
        if ($task -> count() > 0){
            return response() -> json([
                'task' => $task,
            ]);
        } else {
            return response() -> json([
                'message' => "task n'existe pas",
            ]);
        }
    }
}
