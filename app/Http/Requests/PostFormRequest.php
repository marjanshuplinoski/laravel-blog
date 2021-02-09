<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    //check if user is authorized as admin or author
    public function auth(){
        if($this->user()->can_post())
            return true;
        else
            return false;
    }

    //validation rules
    public function rules()
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'title' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'body' => 'required',
        ];
    }

}
