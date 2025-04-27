<?php

namespace   App\Service;

use App\Models\UserSession;

class UserSessionService{

    public function store($payload){
        return UserSession::create([
            'user_id'=>$payload['user_id'],
            'token' => $payload['token'],
        ]);
    }

    public function getObjectFromSessionToken($session_token)
    {
        return UserSession::query()
            ->select('id', 'user_id')
            ->where('token', $session_token)
            ->with([
                'user'
            ])
            ->first();
    }

}