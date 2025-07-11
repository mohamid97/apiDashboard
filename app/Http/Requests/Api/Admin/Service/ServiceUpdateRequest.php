<?php

namespace App\Http\Requests\Api\Admin\Service;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'price'=>'nullable|numeric',
            'category_id'=>'nullable|exists:categories,id',
            'order'=>'nullable|integer|unique:service,order',
            'images'=>'nullable|array',
            'images.*'=>'nullable|image|mimes:jpeg,png,webp,jpg,gif|max:5000',
            'breadcrumb'=>'nullable|image|mimes:jpeg,png,webp,jpg,gif|max:5000',
            'service_image'=>'nullable|image|mimes:jpeg,png,webp,jpg,gif|max:5000',
            'title' => 'required|array|min:1',
            'title.*'=>'required|max:255',
            'small_des' => 'nullable|max:255',
            'des.*'=>'nullable|max:5000',
            'meta_title.*' => 'nullable|max:255',
            'meta_des.*' => 'nullable|max:255',
            
        ];
    }
}
