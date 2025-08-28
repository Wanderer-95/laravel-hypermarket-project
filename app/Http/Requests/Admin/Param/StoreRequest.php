<?php

namespace App\Http\Requests\Admin\Param;

use App\Enums\Param\ParamTypeFilterEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'filter_type' => 'required|integer|in:'.ParamTypeFilterEnum::valuesAsString().'|between:1,3'
        ];
    }
}
