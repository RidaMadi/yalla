<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Auth\SendCodeRequest;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Models\User\TemporaryPhone;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VerifyCodeController extends AppBaseController
{
    public function __construct()
    {
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        //get last record
        $data = TemporaryPhone::where('phone', $request->phone)->firstOrFail();

        if (Carbon::now() > $data->expired_at)
            return $this->handleResponse(ApiCode::BAD_REQUEST,null,'The code has expired',2);

        if ($data->code != $request->code)
            return $this->handleResponse(ApiCode::BAD_REQUEST,null,'The code is incorrect',3);

        return $this->handleResponse(ApiCode::SUCCESS,null,'The code is correct');
    }
}
