<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TicketTypeEnum;
use App\Enums\ClassTypeEnum;

class TailorMadeRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // ممكن تغيرها لو عايز تحقق صلاحيات
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|max:20',
            'duration'         => 'required|string|max:255',
            'travel_date'      => 'required|date',
            'preferred_contact_time'      => 'required|string|max:255',
            'ideal_trip_length'      => 'required|string|max:255',
            'additional_info'      => 'required|string|max:255',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('Full Name')]),
            'name.string'   => __('validation.string', ['attribute' => __('Full Name')]),
            'email.required'     => __('validation.required', ['attribute' => __('Email')]),
            'email.email'        => __('validation.email', ['attribute' => __('Email')]),
            'phone.required'     => __('validation.required', ['attribute' => __('Phone')]),
            'duration.required'     => __('validation.required', ['attribute' => __('Duration')]),
            'travel_date.required'     => __('validation.required', ['attribute' => __('Travel Date')]),
            'preferred_contact_time.required'     => __('validation.required', ['attribute' => __('Preferred Contact Time')]),
            'ideal_trip_length.required'     => __('validation.required', ['attribute' => __('Ideal Trip Length')]),
            'additional_info.required'     => __('validation.required', ['attribute' => __('Additional Info')]),
        ];
    }
}
