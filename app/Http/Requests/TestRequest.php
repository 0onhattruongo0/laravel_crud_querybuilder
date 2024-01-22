<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TestRequest extends FormRequest
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
            "product_name"=> "required|min:6",
            "product_price"=>  "required|integer"
        ];
    }

    public function messages(){
        return [
            'product_name.required' => ':attribute bắt buộc phải nhập',
            'product_name.min' => ':attribute phải lớn hơn 6',
            'product_price.required' => ':attribute bắt buộc phải nhập',
            'product_price.integer' => ':attribute bắt buộc phải là số',
        ];
    }

    public function attributes(){
        return [
            'product_name' => 'Tên sản phẩm',
            'product_price' => 'Gía sản phẩm'
        ];
    }

    // public function withValidator($validator){
    //     $validator->after(function($validator){
    //         if($validator->errors()->count()>0){
    //             $validator->errors()->add('msg','Đã có lỗi xảy ra vui lòng thử lại sau');
    //         }
    //     });
    // }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if($validator->errors()->count()>0){
                    $validator->errors()->add(
                        'msg',
                        'Đã có lỗi xảy ra vui lòng thử lại sau'
                    );
                }
            }
        ];
    }
}
