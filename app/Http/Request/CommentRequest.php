<?php

namespace App\Http\Request;

use App\Enums\StatusCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class CommentRequest extends BaseModuleRequest
{

    public function rules()
    {
        return [
            'contentComment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'contentComment.required' => 'The content field is required',
        ];
    }
}
