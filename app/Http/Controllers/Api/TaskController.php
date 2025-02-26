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
    // // show a task
    public function show($id){
        $task = ModelsTask::where('id',$id) -> where('user_id',auth('api') -> user() -> id) -> get();
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
    // update a task
    public function update(Request $request, $id){
        $validate = $request -> validate([
            'title' => 'required|min:4',
            'due_date' => 'required',
        ]);
        $findTask = ModelsTask::where('id',$id) -> first();
        if (!$findTask){
            return response() -> json(['message'=> "task n'existe pas"],404);
        }
        $task = $findTask -> update([
            'title' => $validate['title'],
            'due_date' => $validate['due_date'],
            'user_id' => auth('api') -> user() -> id
           ]
        );
        return response() -> json(['message' => 'task a ete modifier avec success'],200);
    }
    // destroy
    public function destroy($id){
        if (ModelsTask::find($id) -> delete()){
        return response() -> json(['message'=>'le task a ete supprime avec success'],200);
        } else {
            return response() -> json(['message'=>'la supprission est echoue'],404);
        }
    }
}
