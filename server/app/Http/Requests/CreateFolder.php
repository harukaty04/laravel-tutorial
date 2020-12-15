<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFolder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //リクエストの内容に基づいた権限チェック
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    //入力欄ごとにテェックするルールを定義
    public function rules()
    {
        return [
            'title' => 'required',
        ];
    }
}
