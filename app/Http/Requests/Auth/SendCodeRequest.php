<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class SendCodeRequest extends BaseRequest
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
            'phone' => 'required|regex:/^09\d{8}$/|min:10|max:10',
        ];
    }
}
