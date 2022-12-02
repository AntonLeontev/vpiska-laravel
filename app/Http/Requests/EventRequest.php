<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $yesterday = Carbon::yesterday($this->utc_offset)->format('d-m-Y');
        $beforeDay = Carbon::tomorrow($this->utc_offset)
            ->addDays(config('vpiska.event.beforeDaysCreating', 3))
            ->format('d-m-Y');

        return [
            'creator_id' => ['required', 'exists:users,id'],
            'city_fias_id' => ['required', 'string'],
            'utc_offset' => ['required', 'integer'],
            'city_name' => ['required', 'string'],
            'street_fias_id' => ['required', 'string'],
            'street' => ['required', 'string'],
            'street_type' => ['required', 'string'],
            'building_fias_id' => ['required', 'string'],
            'building' => ['required', 'string'],
            'max_members' => ['required', 'integer', 'min:2'],
            'price' => ['required', 'integer', 'min:0'],
            'fee' => ['required', 'integer', 'min:0'],
            'date' => ['required', 'date', "after:$yesterday", "before:$beforeDay"],
            'time' => ['required', 'string', 'regex:/^([0-1]?\d|2[0-3]):[0-5]\d - ([0-1]?\d|2[0-3]):[0-5]\d$/'],
            'description' => ['nullable', 'max:1000', 'string'],
            'image.*' => ['image', 'nullable', 'max:5120'],
            'user_phone' => ['required', 'regex:/^\+7\(\d{3}\)\d{3}-\d\d-\d\d$/'],
            'phone' => ['sometimes', 'regex:/^[78]\d{10}$/'],
            'scales' => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'city_fias_id.required' => 'Город должен быть выбран из списка',
            'street_fias_id.required' => 'Улица должна быть выбрана из списка',
            'building_fias_id.required' => 'Номер дома должен быть выбран из списка',
        ];
    }
}
