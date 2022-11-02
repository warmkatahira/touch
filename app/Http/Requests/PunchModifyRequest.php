<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PunchModifyRequest extends FormRequest
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
            'begin_time' => 'required',
            'finish_time' => 'required',
            'out_time' => 'nullable|required_with:return_time',
            'return_time' => 'nullable|required_with:out_time',
        ];
    }

    public function messages()
    {
        return [
            'begin_time.required' => '出勤時間は必須です。',
            'finish_time.required' => '退勤時間は必須です。',
            'out_time.required_with' => '戻り時間が入力されているので、外出時間も入力して下さい。',
            'return_time.required_with' => '外出時間が入力されているので、戻り時間も入力して下さい。',
        ];
    }
}
