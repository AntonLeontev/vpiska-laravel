<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserImageDeleteRequest extends FormRequest
{
    public function authorize()
    {
        return (int) $this->userId === Auth::user()->id;
    }

    public function rules()
    {
        return [
            'userId' => ['required', 'exists:users,id'],
        ];
    }
}
