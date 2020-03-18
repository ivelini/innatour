<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'nav_name' => 'required',
            'title' => 'required',
            'description' => 'required',
            'pageImg' => 'mimes:jpeg,jpg,bmp,png|max:1024|dimensions:min_width:800,min_height:600'
        ];
    }
}
