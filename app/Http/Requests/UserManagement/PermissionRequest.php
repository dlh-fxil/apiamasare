<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PermissionRequest extends FormRequest
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
    public function rules(Request $request)
    {
       
        return [
            'group' =>"nullable|string|max:20",
 				'name' =>"required|string|max:255",
 				'description' =>"nullable|string|max:125",
 				'guard_name' =>"required|string|max:255",
 				
        ];
    }

  
  protected function prepareForValidation()
  {
    $this->merge([
        //'slug' => Str::slug($this->slug),
    ]);
  }

  public function attributes()
  {
    return [
        //'email' => 'email address',
    ];
  }
 
 
}
