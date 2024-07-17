<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use Carbon\Carbon;

class LogOutController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('checkAuth');
    }

    public function logout(){
        $user = auth()->user();
        $user->logout_at = Carbon::now();
        $user->remember_token = null;
        $user->save();
        auth()->logout();
        return $this->handleResponse(ApiCode::SUCCESS,null,__("User successfully logged out"));
    }

}
