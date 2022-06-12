<?php

namespace App\Http\Requests\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RoleRequest extends FormRequest
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
    $role = $this->role ?? null;
    if (request()->isMethod('PUT')) {
      $curentLevel = $role->level;
      $level = "max:$curentLevel";
    } else {
      $level = 'max:999';
    }
    $uniqLevel = Rule::unique('roles', 'level')->ignore($this->role);
    $name = Rule::unique('roles', 'name')->ignore($this->role);
    return [
      'name' => ['required', 'string', 'max:125',  $name],
      'guard_name' => ['required', 'string', 'max:125'],
      'description' => ['required', 'string', 'max:125'],
      'level' => ['required', 'numeric', $level, $uniqLevel],
      'permission_names' => ['required', 'array', Rule::exists('permissions', 'name')],
    ];
  }


  protected function prepareForValidation()
  {
    if (!request()->guard_name) {
      $this->merge([
        'guard_name' => 'web',
      ]);
    }
  }

  public function attributes()
  {
    return [
      'name' => 'Nama peran (role)',
      'permission_names' => 'Nama ijin (permission)',
      'description' => 'Deskripsi /keterangan',
    ];
  }
}
