<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required',
            'preferred_travel_date' => 'required|date',
            'adults'         => 'required|integer|min:1',
            'children'       => 'required|integer|min:0',
            'infants'        => 'required|integer|min:0',

        ];
    }

    /**
     * Custom messages for validation errors (optional).
     */
    public function messages(): array
    {

        return [
            'name.required' =>  __('validation.required', ['attribute' => __('Name')]),
            'name.string' => __('validation.string', ['attribute' => __('Name')]),
            'email.required' => __('validation.required', ['attribute' => __('Email')]),
            'email.email' => __('validation.email', ['attribute' => __('Email')]),
            'phone.required' =>  __('validation.required', ['attribute' => __('Phone')]),
            'adults.required'       => __('validation.required', ['attribute' => __('Adults')]),
            'adults.integer'        => __('validation.integer', ['attribute' => __('Adults')]),
            'children.required'       => __('validation.required', ['attribute' => __('Children')]),
            'children.integer'      => __('validation.integer', ['attribute' => __('Children')]),
            'infants.required'       => __('validation.required', ['attribute' => __('Infants')]),
            'infants.integer'       => __('validation.integer', ['attribute' => __('Infants')]),
            'preferred_travel_date.required' =>  __('validation.required', ['attribute' => __('Preferred Travel Date')]),
            'preferred_travel_date.date' => __('validation.date', ['attribute' => __('Preferred Travel Date')]),

            // 'notes.required' =>  __('validation.required', ['attribute' => __('Message')]),
            // 'notes.string' => __('validation.string', ['attribute' => __('Message')]),



        ];
    }
}
