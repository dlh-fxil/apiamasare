<?php

namespace App\Http\Requests\Kegiatan;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FollowKegiatanRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()

    {
        return [
            'uraian_tugas_id' => [
                'nullable',
                Rule::exists('uraian_tugas', 'id')
                    ->where(fn ($query) =>
                    $query->where([['deleted_at', null], ['jabatan_id', $this->jabatan_id]]))
            ],
            'kegiatan_id' => [
                'required',
                Rule::exists('item_kegiatan', 'id')
                    ->where(fn ($query) =>
                    $query->where([['deleted_at', null], ['selesai', null]]))
            ],
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'kegiatan_id' => $this->kegiatan->id,
        ]);
        if (request()->uraian_tugas_id && request()->user()->jabatan_id) {
            $this->merge([
                'jabatan_id' => auth()->user()->jabatan_id,
            ]);
        }
    }


    public function messages()
    {
        return [
            'uraian_tugas_id.exists' => 'Uraian tugas tidak ditemukan atau uraian tugas ini bukan untuk jabatan anda',
        ];
    }
}
