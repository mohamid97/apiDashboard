<?php

namespace App\Http\Requests\Api\Admin\Social;

use App\Traits\ResponseTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SocialStoreRequest extends FormRequest
{
    use ResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [];

        $platforms = [
            'facebook', 'twitter', 'instagram', 'youtube', 'linkedin',
            'tiktok', 'pinterest', 'snapchat', 'email', 'phone'
        ];

        foreach ($platforms as $platform) {
            $rules[$platform] = 'nullable|string|max:255';
            $rules["{$platform}_cta"] = 'nullable|boolean';
            $rules["{$platform}_layout"] = 'nullable|boolean';
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(
                $validator->errors()->first(), 
                422, 
                
            )
        );
    }

    
}