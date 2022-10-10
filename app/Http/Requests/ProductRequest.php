<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'=>'required|max:100|unique:products,name,'.$this->id,
            'section'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'يرجى ادخال اسم المنتج',
            'name.unique'=>'اسم المنتج موجود بالفعل الرجاء وضع اسم غيره',
            'name.max'=>'اسم المنتج يجب ان لا يتجاوز 100 حرف',
            'section.required'=>'يجب تحديد القسم'
        ];
    }


}
