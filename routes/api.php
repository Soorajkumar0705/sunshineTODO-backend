<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/register",[AuthController::class,'register']);
Route::post("/login",[AuthController::class,'login']);

Route::middleware('auth_session')->group(function(){
   Route::get('/todo',[TodoController::class,'index']); 
   Route::post('/todo/store',[TodoController::class,'store']);
   Route::post('/todo/{todo_id}/show',[TodoController::class,'show']);
   Route::post('/todo/{todo_id}/update',[TodoController::class,'update']);
   Route::post('/todo/{todo_id}/delete',[TodoController::class,'delete']);
});