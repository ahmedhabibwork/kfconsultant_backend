<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\CarTypeEnum;

class TransportBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust if you need auth check
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
            'destination'    => 'required|string|max:255',
            'trip_date'      => 'required|date|after_or_equal:today',
            'trip_time'      => 'required|date_format:H:i',
            'people_count'   => 'required|integer|min:1',
            'car_type'       => ['required', new Enum(CarTypeEnum::class)],
            'special_requests' => 'required|string|max:1000',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required'        => __('validation.required', ['attribute' => __('Full Name')]),
            'email.required'       => __('validation.required', ['attribute' => __('Email')]),
            'email.email'          => __('validation.email', ['attribute' => __('Email')]),
            'phone.required'       => __('validation.required', ['attribute' => __('Phone Number')]),
            'destination.required' => __('validation.required', ['attribute' => __('Destination')]),
            'trip_date.required'   => __('validation.required', ['attribute' => __('Trip Date')]),
            'trip_date.after_or_equal' => __('The trip date must be today or a future date.'),
            'trip_time.required'   => __('validation.required', ['attribute' => __('Trip Time')]),
            'trip_time.date_format' => __('The trip time must be in the format HH:MM.'),
            'people_count.required' => __('validation.required', ['attribute' => __('Number of People')]),
            'people_count.integer' => __('validation.integer', ['attribute' => __('Number of People')]),
            'car_type.required'    => __('validation.required', ['attribute' => __('Car Type')]),
            'special_requests.required' => __('validation.required', ['attribute' => __('Special Requests')]),
        ];
    }
}
