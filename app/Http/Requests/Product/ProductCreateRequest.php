<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'          => "required|min:5|max:150",
            'price'         => 'required|numeric|max:9999999',
            'description'   => 'required|max:10000',
            'category_id'   => 'required|exists:categories,id',
            'product_image' => 'required|image|max:2000|mimes:jpeg,jpg,png',
        ];
    }
}
