<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'product.category_id' => 'required|integer|exists:categories,id',
            'product.product_group_id' => 'required|integer|exists:product_groups,id',
            'product.article' => ['required', 'integer', Rule::unique('products', 'title')->ignore($this->route('product')->id)],
            'product.title' => ['required', 'string', 'max:255'],
            'product.description' => 'required|string',
            'product.content' => 'required|string',
            'product.price' => 'required|numeric',
            'product.old_price' => 'required|numeric',
            'product.qty' => 'required|integer',
            'product.parent_id' => 'nullable|integer|exists:products,id',
            'images' => 'nullable|array',
            'images.*' => 'required|file',
            'params' => 'nullable|array',
            'params.*.param_id' => 'required|integer|exists:params,id',
            'params.*.value' => 'required|string',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        dd($validator->errors()->toArray());
    }
}
