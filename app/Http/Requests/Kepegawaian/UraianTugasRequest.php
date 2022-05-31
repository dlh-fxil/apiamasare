<?php

namespace App\Http\Requests\Kepegawaian;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UraianTugasRequest extends FormRequest
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
      'jabatan_id' => "required|numeric",
      'jenis_tugas' => "nullable|string|max:125",
      'uraian_tugas' => "required|string|max:125",
      'indikator' => "nullable|string|max:125",
      'angka_kredit' => "nullable|numeric",
      'keterangan' => "nullable|string|max:125",
      'created_by' => "nullable|numeric",

    ];
  }

  protected function prepareForValidation()
  {
    $this->merge([
      'created_by' => $this->user()->id,
    ]);
    if (!$this->jabatan_id) {
      $this->merge([
        'jabatan_id' => request()->user()->jabatan_id
      ]);
    }
  }


  public function attributes()
  {
    return [
      //'email' => 'email address',
    ];
  }
}
