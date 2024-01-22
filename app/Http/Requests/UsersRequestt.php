<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequestt extends FormRequest
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
        $uniqueEmail= 'unique:users';
        $id = session('id');
        if(!empty($id)){
            $uniqueEmail= 'unique:users,email,'.$id;
        }
        return [
            'fullname' => 'required|min:5',
            'email' => 'required|email|'.$uniqueEmail,
            'group_id' => ['required','integer', function($attribute,$value,$fail){
                if($value == 0){
                    $fail('Vui lòng chọn nhóm');
                }
            }],
            'status' => 'required|integer',
        ];
    }

    public function messages(){
        return [
            'fullname.required' => 'Họ tên không được để trống',
            'fullname.min' => 'Họ tên ít nhất phải 5 ký tự',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Định dạng email không đúng',
            'email.unique' => 'Email đã tồn tại',
            'group_id.required' => 'Vui lòng chọn nhóm...',
            'group_id.integer' => 'Kiểu định dạng nhóm không phù hợp',
            'status.required' => 'Trạng thái không được để trống',
            'status.integer' => 'Kiểu định dạng trạng thái không phù hợp',
        ];
    }
}
