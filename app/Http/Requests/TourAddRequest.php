<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourAddRequest extends FormRequest
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
            'title' => 'required|string|min:10',
            'description' => 'required|min:100',
            'categoriesId' => 'required',
            'uploadPhotos' => 'required',
            'uploadPhotos.*' => 'mimes:jpeg,jpg,bmp,png|max:2548|dimensions:min_width:800,min_height:600',
            'price' => 'required|numeric',
            'file_name' => 'required_with:file_path'
        ];
    }
}
