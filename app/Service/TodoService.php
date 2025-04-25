<?php 

namespace   App\Service;

use App\Models\Todo;
use GuzzleHttp\Psr7\FnStream;

class TodoService{

    public function getTodosByUserId($user_id){
        return Todo::where('user_id',$user_id)
        ->orderBy('isFavorite','desc')
        ->paginate(30);
    }

    public function store($payload){
        return Todo::create([
            'user_id'=>$payload['user_id'],
            'priority'=>$payload['priority'],
            'title'=>$payload['title'],
            'description'=>$payload['description'],
        ]);
    }

    public function getTodoById($payload){
        return Todo::where(['user_id'=>$payload['user_id'],'id'=>$payload['todo_id']])->firstOrFail();
    }

    public function updateTodo(Todo $todo, $payload){
        return $todo->update($payload);
    }

    public function deleteTodo(Todo $todo){
        return $todo->delete();
    }

}