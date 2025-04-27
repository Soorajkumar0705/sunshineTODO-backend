<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(
    ){
        //
    }

    public function index(Request $request){
        try {
            DB::beginTransaction();
                $user = $request->get('user');
            DB::commit();
            return response()->successJson($user, [
                'message' => 'Here is your user data.'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->errorJson([], [
                'message' => 'Something went wrong. Please try again.'
            ], 500);
        }
    }
}
