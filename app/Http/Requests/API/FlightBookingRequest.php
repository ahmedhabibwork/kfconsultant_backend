<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TicketTypeEnum;
use App\Enums\ClassTypeEnum;

class FlightBookingRequest extends FormRequest
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
            'ticket_type'    => ['required', new Enum(TicketTypeEnum::class)],
            'origin'         => 'required|string|max:255',
            'destination'    => 'required|string|max:255',
            'class_type'     => ['required', new Enum(ClassTypeEnum::class)],
            'adults'         => 'required|integer|min:1',
            'children'       => 'required|integer|min:0',
            'infants'        => 'required|integer|min:0',
            'departure_date' => 'required|date',
            'return_date' => [
                'required_if:ticket_type,' . TicketTypeEnum::ROUND_TRIP->value,
                'nullable',
                'date',
                'after_or_equal:departure_date',
            ],

            

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

            'ticket_type.required' => __('validation.required', ['attribute' => __('Ticket Type')]),
            'origin.required'      => __('validation.required', ['attribute' => __('From')]),
            'destination.required' => __('validation.required', ['attribute' => __('To')]),
            'class_type.required'  => __('validation.required', ['attribute' => __('Class Type')]),

            'adults.required'       => __('validation.required', ['attribute' => __('Adults')]),
            'adults.integer'        => __('validation.integer', ['attribute' => __('Adults')]),
            'children.integer'      => __('validation.integer', ['attribute' => __('Children')]),
            'infants.integer'       => __('validation.integer', ['attribute' => __('Infants')]),

            'departure_date.required' => __('validation.required', ['attribute' => __('Departure Date')]),
            'departure_date.date'     => __('validation.date', ['attribute' => __('Departure Date')]),
            'return_date.date'        => __('validation.date', ['attribute' => __('Return Date')]),
            'departure_date.after_or_equal' => __('The Departure Date must be a date after or equal to today.'),
            'return_date.after_or_equal' => __('The return date must be after or equal to the departure date.'),
        ];
    }
}
