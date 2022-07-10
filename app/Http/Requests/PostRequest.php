<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 認証チェックを此処で行わない場合はtrueにしておく
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|between:1,20',
            'content' => 'nullable|string|between:1,100',
            'user_id' => 'required|integer|min:1',
            'image' => 'nullable|string',
            'image_name' => 'nullable|string'
        ];
    }

    // apiで叩く為バリデーションエラーをjsonで返すようにする（デフォルトではエラーメッセージと送信元のviewを返す）
    protected function failedValidation(Validator $validator)
    {
        //response codeとjsonで返すエラーメッセージ2箇所に400番のステータス
        $response = response()->json([
            'status' => 400,
            'errorMessages' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}