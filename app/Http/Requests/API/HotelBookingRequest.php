<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\RoomTypeEnum;

class HotelBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // عدلها لو محتاج تحقق صلاحيات
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'country'        => 'required|string|max:255',
            'arrival_date'   => 'required|date|after_or_equal:today',
            'departure_date' => 'required|date|after:arrival_date',
            'people_count'   => 'required|integer|min:1',
            'room_type'      => ['required', new Enum(RoomTypeEnum::class)],
            'special_requests' => 'required|string|max:1000',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required'           => __('validation.required', ['attribute' => __('Full Name')]),
            'email.required'          => __('validation.required', ['attribute' => __('Email')]),
            'email.email'             => __('validation.email', ['attribute' => __('Email')]),
            'phone.required'          => __('validation.required', ['attribute' => __('Phone Number')]),
            'country.required'        => __('validation.required', ['attribute' => __('Country')]),
            'arrival_date.required'   => __('validation.required', ['attribute' => __('Arrival Date')]),
            'arrival_date.after_or_equal' => __('The arrival date must be today or a future date.'),
            'departure_date.required' => __('validation.required', ['attribute' => __('Departure Date')]),
            'departure_date.after'    => __('The departure date must be after the arrival date.'),
            'people_count.required'   => __('validation.required', ['attribute' => __('Number of People')]),
            'people_count.integer'    => __('validation.integer', ['attribute' => __('Number of People')]),
            'room_type.required'      => __('validation.required', ['attribute' => __('Room Type')]),
            'special_requests.required' => __('validation.required', ['attribute' => __('Special Requests')]),
        ];
    }
}
