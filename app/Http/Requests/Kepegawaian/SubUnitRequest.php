<?php

namespace App\Http\Requests\Kepegawaian;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubUnitRequest extends FormRequest
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
      'jenis' => "required|string|max:20",
      'nama' => "required|string|max:100",
      'singkatan' => "nullable|string|max:100",
      'unit_id' => "nullable|numeric",

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
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'errors' => $validator->errors()
    ], 422));
  }
}
