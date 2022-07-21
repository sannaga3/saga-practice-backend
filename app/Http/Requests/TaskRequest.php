<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


class TaskRequest extends FormRequest
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
            'name' => 'required|string|between:1,20',
            'purpose' => 'nullable|string|between:1,30',
            'action' => 'required|string',
            'times_unit' => 'required|string',
            'target_times' => 'required|string',
            'times_unit' => 'required|string',
            'schedule_start' => 'required|string',
            'schedule_end' => 'required||string',
            'remarks' => 'nullable|string',
            'status' => 'required||string',
            'user_id' => 'required|integer|min:1',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 400,
            'errorMessages' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}