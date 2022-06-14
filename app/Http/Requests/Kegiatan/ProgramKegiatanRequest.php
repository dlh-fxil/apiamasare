<?php

namespace App\Http\Requests\Kegiatan;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProgramKegiatanRequest extends FormRequest
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
      'created_by' => ['required', Rule::exists('users', 'id')->where(fn ($query) => $query->where('deleted_at', null))],
      'id_kegiatan' => "nullable|numeric|prohibited_unless:type,subKegiatan|required_if:type,subKegiatan",
      'id_program' => "nullable|numeric|prohibitedIf:type,program|required_unless:type,program",
      'indikator' => "nullable|required_if:type,subKegiatan|string|max:500",
      'kinerja' => "nullable|required_if:type,subKegiatan|string|max:500",
      'kode_bidang_urusan' => "required|string|max:4",
      'kode_kegiatan' => "nullable|prohibitedIf:type,program|required_unless:type,program|string|max:4",
      'kode_program' => "required|string|max:4",
      'kode_sub_kegiatan' => "nullable|prohibited_unless:type,subKegiatan|required_if:type,subKegiatan|string|max:4",
      'kode_urusan' => "required|string|max:4",
      'nomenklatur' => "required|string|max:500",
      'realisasi_biaya' => "nullable|numeric",
      'realisasi_jumlah_hasil' => "nullable|numeric",
      'satuan' => "nullable|required_with:target_jumlah_hasil|string|max:100",
      'selesai' => "nullable|boolean",
      'tahun_anggaran' => 'required|digits:4|integer|min:' . (date('Y') - 1) . '|max:' . (date('Y') + 1),
      'target_biaya' => "nullable|numeric",
      'target_jumlah_hasil' => "nullable|numeric",
      'target_waktu_pelaksanaan' => "nullable|required_if:type,subKegiatan|numeric",
      'type' => "required|in:program,kegiatan,subKegiatan",
      'unit_id' => ['required', Rule::exists('unit', 'id')->where(fn ($query) => $query->where('deleted_at', null))],
    ];
  }


  protected function prepareForValidation()
  {
    $this->merge([
      'created_by' => request()->user()->id,
    ]);
  }

  public function attributes()
  {
    return [
      //'email' => 'email address',
    ];
  }
}
