<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->id === $this->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $yesterday = today()->subDay();
        return [
            'first_name' => ['string', 'nullable', 'max:25', 'min:2'],
            'last_name' => ['string', 'nullable', 'max:25', 'min:2'],
            'city_fias_id' => ['required_with:city_name', 'string', 'nullable'],
            'city_name' => ['string', 'nullable'],
            'birth_date' => ['date', "before:$yesterday", 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'city_fias_id.required_with' => 'Город нужно выбрать из списка',
            'birth_date.before' => 'Указана неподходящая дата рождения'
        ];
    }
}
