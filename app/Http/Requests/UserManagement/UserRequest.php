<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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


    $nip = Rule::unique('users', 'nip')->where(fn ($query) => $query->where('deleted_at', null))->ignore($this->user);
    return
      [
        'eselon' => 'nullable|string|max:20',
        'jabatan_id' => 'required|exists:jabatan,id',
        'jenis_pegawai' => 'required|string|max:6',
        'name' => 'required|string|max:50',
        'nip' => ['nullable', 'prohibitedIf:jenis_pegawai,PPNPNS', 'required_unless:jenis_pegawai,PPNS', 'string', 'max:20', $nip],
        'no_hp' => 'nullable|string|max:20',
        'no_wa' => 'nullable|string|max:20',
        'pangkat_id' => ['nullable', 'prohibitedIf:jenis_pegawai,PPNPNS|required_unless:jenis_pegawai,PPNS', 'exists:pangkat,id'],
        'sub_unit_id' => 'nullable|exists:sub_unit,id',
        'unit_id' => 'nullable|exists:unit,id',
      ];
  }


  // protected function prepareForValidation()
  // {
  //   $this->merge([
  //     //'slug' => Str::slug($this->slug),
  //   ]);
  // }

  public function attributes()
  {
    return [
      'name' => 'Nama Pegawai',
      'jenis_pegawai' => 'jenis kepegawaian',
      'no_hp' => 'Nomor HP',
      'no_wa' => 'Nomor WA',
      'pangkat_id' => 'Pangkat',
      'jabatan_id' => 'Jabatan',
      'unit_id' => 'Unit/Bagian/Sekretariat',
      'sub_unit_id' => 'Sub Unit/Seksi/Sub bagian',
    ];
  }
}
