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
        $tasks = ModelsTask::all();
        if ($tasks -> count() > 0){
            return TaskResource::collection($tasks);
        } else {
            return response() -> json([ 'message' => "Il y'a aucune task pour vous"],200);
        }
    }
    // // create a task
    // public function store(Request $request){
    //     $validate = Validator::make($request -> all(),[
    //         'title' => 'required|min:4',
    //         'due_date' => 'required',
    //         'user_id' => Auth::
    //     ]);
    // }
}
