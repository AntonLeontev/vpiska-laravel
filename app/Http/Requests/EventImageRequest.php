<?php

namespace App\Http\Requests;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EventImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('event')->creator_id === auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $maxImages = config('vpiska.max_photo_per_event', 5) - EventImage::where('event_id', $this->event_id)->count();
        return [
            'images' => ['required', "max:$maxImages"],
            'images.*' => [
                'required',
                'image',
                'max:' . (config('vpiska.max_image_size')),
                Rule::dimensions()
                    ->minWidth(config('vpiska.min_image_width', 200))
                    ->minHeight(config('vpiska.min_image_height', 200)),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'images.max' => 'Еще можно добавить не более :max фото',
        ];
    }
}
