<?php

namespace App\Http\Controllers\Auth;

use App\ApiCode;
use App\Http\Controllers\AppBaseController;
use App\Models\User\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class RefreshTokenController extends AppBaseController
{
    public function __construct()
    {
//        $this->middleware('checkAuth');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {

        $token = $request->header('Authorization');

        // Check if the token starts with 'Bearer '
        if (substr($token, 0, 7) === 'Bearer ') {
            $searchToken = substr($token, 7);
        }

        // Authenticate user by token
        $user = User::where('remember_token',$searchToken)->select('id','remember_token')->first();


        JWTAuth::setToken($searchToken);
        $newToken = JWTAuth::refresh();

        $data = $this->respondWithToken($newToken);

        // Update user's remember token
        $user->update(['remember_token' => $data['token']]);

        return $this->handleResponse(ApiCode::CREATED, $data, 'Refresh token returned successfully.');

    }

    protected function respondWithToken($token): array
    {
        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

}
