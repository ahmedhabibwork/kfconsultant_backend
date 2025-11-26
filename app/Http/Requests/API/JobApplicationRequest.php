<?php

namespace App\Http\Requests\API;

use App\Enums\GoalEnum;
use App\Enums\JobTitleEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
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
            'job_title' => ['required', new Enum(JobTitleEnum::class)],
            'image' => 'required|image|max:2048',
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

            'job_title.required'      => __('validation.required', ['attribute' => __('Job Title')]),
            'image.required'      => __('validation.required', ['attribute' => __('Image')]),
            'image.image'      => __('validation.image', ['attribute' => __('Image')]),
            


        ];
    }
}
