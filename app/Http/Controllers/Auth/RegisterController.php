<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\TemporaryPhone;
use App\Models\User\User;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisterController extends AppBaseController
{
    public function __construct()
    {
    }

    public function register(RegisterRequest $request)
    {
        // Validate and fetch temporary phone data
        $data = TemporaryPhone::where('phone', $request->phone)->firstOrFail();

        // Verify the code
        if ($data->code != $request->code) {
            return $this->handleResponse(ApiCode::BAD_REQUEST, null, 'The code is incorrect', 2);
        }

        // Check if user already exists
        $user = User::where('phone', $request->phone)->first();

        if ($user) {
            // Update existing user
            $user->update([
                'gender' => $request->gender,
                'username' => $request->username,
                'address_id' => $request->address_id
            ]);
        } else {
            // Create a new user
            $user = User::create([
                'phone' => $request->phone,
                'gender' => $request->gender,
                'username' => $request->username,
                'address_id' => $request->address_id
            ]);
        }

        // Validate and fetch credentials
        $input = $request->validated();

        // Generate token
        $data = [
            "token" => JWTAuth::fromUser($user),
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
        // Save token to the user's record
        $user->update(['remember_token' => $data['token']]);

        return $this->handleResponse(ApiCode::CREATED, $data, 'Registered successfully');
    }

}
