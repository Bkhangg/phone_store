<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required',
            'thumbnail' => 'required|image',
            'images.*' => 'image',
            'description' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'price.numeric' => 'Giá phải là số',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'thumbnail.required' => 'Vui lòng chọn ảnh chính',
            'thumbnail.image' => 'Ảnh chính phải là file hình ảnh',
            'images.*.image' => 'Ảnh phụ phải là file hình ảnh',
            'description.string' => 'Mô tả không hợp lệ'
        ];
    }
}
