<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'term' => 'required|string|min:2'
        ];
    }
}
