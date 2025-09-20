<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'subject' => 'required|string',
            'notes' => 'required|string',
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

            'subject.required' =>  __('validation.required', ['attribute' => __('Subject')]),
            'subject.string' => __('validation.string', ['attribute' => __('Subject')]),




            'email.required' => __('validation.required', ['attribute' => __('Email')]),
            'email.email' => __('validation.email', ['attribute' => __('Email')]),



            'phone.required' =>  __('validation.required', ['attribute' => __('Phone')]),
            'notes.required' =>  __('validation.required', ['attribute' => __('Message')]),
            'notes.string' => __('validation.string', ['attribute' => __('Message')]),



        ];
    }
}
