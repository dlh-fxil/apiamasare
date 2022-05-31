<?php

namespace App\Http\Requests\Kegiatan;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class KegiatanRequest extends FormRequest
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
      'judul' => "required|string|max:255",
      'kode_sub_kegiatan' => "nullable|string",
      'mulai' => "required|date|date_format:Y-m-d H:i:s",
      'program_kegiatan_id' => ['required', Rule::exists('program_kegiatan', 'id')->where(fn ($query) => $query->where('deleted_at', null))],
      'selesai' => "nullable|date|date_format:Y-m-d H:i:s",
      'uraian_tugas_id' => ['nullable', Rule::exists('uraian_tugas', 'id')->where(fn ($query) => $query->where('deleted_at', null))],
      'uraian' => "required|string",
      // 'unit_id' => ['nullable', Rule::exists('unit', 'id')->where(fn ($query) => $query->where('deleted_at', null))],
    ];
  }


  protected function prepareForValidation()
  {

    $date = null;
    if (request()->mulai) {
      $date = date('Y-m-d H:i:s', strtotime(request()->mulai));
    }
    $this->merge([
      'mulai' => $date ?? ($this->kegiatan->mulai ?? null),

    ]);
    if (request()->isMethod('delete')) {
      $this->merge([
        'judul' => $this->kegiatan->judul,
        'uraian' => $this->kegiatan->uraian,
        'mulai' => $this->kegiatan->mulai,
      ]);
    }
  }

  public function attributes()
  {
    return [
      'created_by' => 'Data User',
      'judul' => 'Judul kegiatan',
      'program_kegiatan_id' => 'Data Program Kegiatan',
      'uraian_tugas_id' => 'Uraian Tugas',
      'uraian' => 'Detail / Uraian kegiatan',
      // 'unit_id' => 'Data Unit',
    ];
  }
  public function messages()
  {
    return [
      'created_by.required' => 'Anda belum login',
      'created_by.exists' => 'Data user tidak ditemukan',
    ];
  }
}
