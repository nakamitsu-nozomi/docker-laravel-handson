<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "zipcode" => [
                "required",
                'digits:7'
            ],
            "addr11" => [
                "required"
            ],

            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u'
        ];
    }
    public function attributes()
    {
        return [
            "zipcode" => "郵便番号",
            "address" => "位置情報",
            "addr11" => "位置情報",
            "tags" => "タグ",
        ];
    }
    // フォームリクエストのバリデーションが成功した後に自動的に呼ばれるメソッド
    public function passedValidation()
    {
        $this->tags = collect(json_decode($this->tags))
            ->slice(0, 5)
            ->map(function ($requestTag) {
                return $requestTag->text;
            });
    }
}
