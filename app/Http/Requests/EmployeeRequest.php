<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            // 従業員番号は更新時に自分以外を対象とするようにしている
            'employee_no' => [
                Rule::unique('employees')->ignore($this->employee_no, 'employee_no'),
                'required',
                'max:4',
                'min:4'
            ],
            'employee_name' => 'required|max:30',
            'over_time_start_setting' => 'nullable|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'employee_no.required' => '従業員番号を入力して下さい。',
            'employee_no.unique' => '従業員番号は既に存在しています。',
            'employee_no.max' => '従業員番号は4桁で入力して下さい。',
            'employee_no.min' => '従業員番号は4桁で入力して下さい。',
            'employee_name.required' => '従業員名を入力して下さい。',
            'employee_name.max' => '従業員名は30文字以内で入力して下さい。',
            'over_time_start_setting.numeric' => '残業開始時間は数値で入力して下さい。',
            'over_time_start_setting.min' => '残業開始時間は1以上の数値で入力して下さい。（設定しない場合は空欄にして下さい。）',
        ];
    }
}
