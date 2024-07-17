<?php

namespace App\Http\Requests\Auth;

use App\Enum\User\UserGender;
use App\Http\Requests\BaseRequest;


class RegisterRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:100',
            'gender' => 'required|in:'.UserGender::MALE.','.UserGender::FEMALE,
            'address_id' => 'required|integer|exists:addresses,id',

            'phone' => 'required|regex:/^09\d{8}$/|min:10|max:10|exists:temporary_phones,phone',
            'code' => 'required|string',
        ];
    }
}
