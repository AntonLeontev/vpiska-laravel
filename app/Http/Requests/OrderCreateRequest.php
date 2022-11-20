<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderCreateRequest extends FormRequest
{
    public function authorize()
    {
        return (int) $this->customer_id === Auth::user()->id;
    }

    public function rules()
    {
        return [
            'customer_id'      => ['required', 'exists:users,id'],
            'event_id'         => ['required', 'exists:events,id'],
            'scales'           => ['required', 'accepted'],
            'pay_from_account' => ['required'],
        ];
    }
}
