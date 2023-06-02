<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserModifyRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'user_id' => 'required|max:20|unique:users,user_id,'.$this->id.',id',
            'user_name' => 'required|max:20',
            'email' => 'required|unique:users,email,'.$this->id.',id',
            'role_id' => 'required|exists:roles,role_id',
            'base_id' => 'required|exists:bases,base_id',
            'status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attributeは必須です。",
            'max' => ":attributeは:max文字以内で入力して下さい。",
            'unique' => ":attributeは既に使用されています。",
            'exists' => "存在しない:attributeです。",
            'boolean' => ":attributeが正しくありません。",
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'ユーザーID',
            'user_name'   => 'ユーザー名',
            'email'   => 'メールアドレス',
            'role_id'   => '権限',
            'base_id'   => '拠点',
            'status'   => 'ステータス',
        ];
    }
}
