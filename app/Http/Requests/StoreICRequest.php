<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreICRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->is('api/*')){
            $response = ApiResponse::sendResponse(422,'Validation Error', $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'commName' => 'nullable|string',
            'image' => 'required|exists:images,id',
            'blog_diagram' => 'required|exists:images,id',
            'store_id' => 'required|exists:stores,id',
            'manName' => 'nullable|string',
            'videoUrl' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'commName' => 'Commercial Name',
            'image' => 'Image',
            'blog_diagram' => 'Blog Diagram',
            'store_id' => 'Store',
            'manName' => 'Manufacturer Name',
            'videoUrl' => 'Video Url',
        ];
    }
}
