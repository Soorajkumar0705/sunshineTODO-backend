<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\StoreRequest;
use App\Service\TodoService;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TodoController extends Controller
{

    public function __construct(
        public TodoService $todoService
    ){
        //
    }
    public function index(Request $request){
        try {
            DB::beginTransaction();
                $user_id = $request->get('user')->id;
                $todos = $this->todoService->getTodosByUserId($user_id);
            DB::commit();
            return response()->successJson($todos, [
                'message' => 'Todo is successfully created.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function store(StoreRequest $request){
        try {
            DB::beginTransaction();
            
            $user_id = $request->get('user')->id;

                $payload = [
                    'user_id'=>$user_id,
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'priority'=>$request->priority
                ];
                
                $todo = $this->todoService->store($payload);
            DB::commit();
            return response()->successJson($todo, [
                'message' => 'Todo is successfully created.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function update(Request $request, $todo_id){
        try {
            DB::beginTransaction();
            
            $user_id = $request->get('user')->id;

            $payload = [
                'user_id'=>$user_id,
                'todo_id'=>$todo_id
            ];

            $todo = $this->todoService->getTodoById($payload);
            
            $request->user_id = $payload['user_id'];

            $updateTodo = $this->todoService->updateTodo($todo,$request->all());

            DB::commit();
            return response()->successJson($todo, [
                'message' => 'Todo is successfully updated.'
            ], 200);
        }
        catch(ModelNotFoundException){
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Todo not found.'
            ], 404);
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
    public function show(Request $request, $todo_id){
        try {
            DB::beginTransaction();
            
            $user_id = $request->get('user')->id;

            $payload = [
                'user_id'=>$user_id,
                'todo_id'=>$todo_id
            ];

            $todo = $this->todoService->getTodoById($payload);

            DB::commit();
            return response()->successJson($todo, [
                'message' => 'Here is your Todo.'
            ], 200);
        }
        catch(ModelNotFoundException){
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Todo not found.'
            ], 404);
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function delete(Request $request, $todo_id){
        try {
            DB::beginTransaction();
            
            $user_id = $request->get('user')->id;

            $payload = [
                'user_id'=>$user_id,
                'todo_id'=>$todo_id
            ];

            $todo = $this->todoService->getTodoById($payload);

            $this->todoService->deleteTodo($todo);

            DB::commit();
            return response()->successJson([], [
                'message' => 'Todo is successfully deleted.'
            ], 200);
        }
        catch(ModelNotFoundException){
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Todo not found.'
            ], 404);
        }
        catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

}
