<?php

namespace App\Http\Request;

use App\Enums\StatusCode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class CategoryRequest extends BaseModuleRequest
{

    public function rules()
    {
        return [
            'name'   => 'required|min:5|max:255|unique:categories'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Please choose another name because this name already exists'
        ];
    }
}
