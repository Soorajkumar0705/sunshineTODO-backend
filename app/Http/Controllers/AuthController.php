<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Service\UserService;
use App\Service\UserSessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function __construct(
       public UserService  $userService,
       public UserSessionService  $userSessionService,
    ){

    }

    public function register(RegisterRequest $Request){
        try {
            DB::beginTransaction();
                $user = $this->userService->register($Request->all());
            DB::commit();
            return response()->successJson($user, [
                'message' => 'User successfully register.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function login(LoginRequest $request){
        try {
            DB::beginTransaction();
                $user = $this->userService->login($request->all());
                
                if(!$user){
                    return response()->errorJson([], [
                        'message' => 'Invalid Credentials.'
                    ], 401);
                }

                $session_token = $this->userService->generateToken();
                $session = $this->userSessionService->store(['token'=> $session_token,'user_id'=>$user->id]);
                
            DB::commit();
            return response()->successJson($session, [
                'message' => 'Here is your token.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([$th->getMessage()], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

    public function forgetPassword(){
        try {
            DB::beginTransaction();
                $user = $this->userService->login($request->all());
                
                if(!$user){
                    return response()->errorJson([], [
                        'message' => 'Invalid Credentials.'
                    ], 401);
                }

                $session_token = $this->userService->generateToken();
                $session = $this->userSessionService->store(['token'=> $session_token,'user_id'=>$user->id]);
                
            DB::commit();
            return response()->successJson($session, [
                'message' => 'Here is your token.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([$th->getMessage()], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }

}
