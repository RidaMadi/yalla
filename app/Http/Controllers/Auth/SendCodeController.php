<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Models\User\TemporaryPhone;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SendCodeController extends AppBaseController
{
    public function __construct()
    {
    }

    public function sendCode(SendCodeRequest $request)
    {
//      //$code = Str::random(8);
        $code = "aaaaaaaa";

        //get last record
        $data = TemporaryPhone::where('phone',$request->phone)->first();

        if ($data){
            //check if he has expired code
            if ($data->expired_at >= Carbon::now()){
                return $this->handleResponse(ApiCode::BAD_REQUEST,null,'Please wait 2 minutes before requesting the code again',2);
            }
            //update code
            $data->update([
                'code' => $code,
                'expired_at' => Carbon::now()->addMinutes(2)
            ]);
        }else{
            //create new record
            TemporaryPhone::create([
                'phone' => $request->phone,
                'code' => $code,
                'expired_at' => Carbon::now()->addMinutes(2),
            ]);
        }
        //send code
        //

        return $this->handleResponse(ApiCode::SUCCESS,null,'code sent successfully');
    }
}
