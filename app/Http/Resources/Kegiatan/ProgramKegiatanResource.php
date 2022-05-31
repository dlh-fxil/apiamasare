<?php

namespace App\Http\Resources\Kegiatan;

use App\Http\Resources\Kepegawaian\UnitResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramKegiatanResource extends JsonResource
{
    /**
     * @var null
     */
    protected $message = null;

    /**
     * @param $message
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'biaya' => $this->biaya,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'deleted_at' => $this->deleted_at,
            'id_kegiatan' => $this->id_kegiatan,
            'id_program' => $this->id_program,
            'id' => $this->id,
            'indikator' => $this->indikator,
            'kinerja' => $this->kinerja,
            'kode' => $this->kode_urusan . '-' . $this->kode_bidang_urusan . '-' . $this->kode_program . ($this->kode_kegiatan ? '-' . $this->kode_kegiatan . ($this->kode_sub_kegiatan ? '-' . $this->kode_sub_kegiatan : '') : ''),
            'kode_bidang_urusan' => $this->kode_bidang_urusan,
            'kode_kegiatan' => $this->kode_kegiatan,
            'kode_program' => $this->kode_program,
            'kode_sub_kegiatan' => $this->kode_sub_kegiatan,
            'kode_urusan' => $this->kode_urusan,
            'nomenklatur' => $this->nomenklatur,
            'kegiatan' => new ProgramKegiatanResource(($this->whenNotNull($this->whenLoaded('kegiatan')))),
            'program' => new ProgramKegiatanResource(($this->whenNotNull($this->whenLoaded('program')))),
            'unit' => new UnitResource(($this->whenNotNull($this->whenLoaded('unit')))),
            'progress' => $this->progress,
            'satuan' => $this->satuan,
            'selesai' => $this->selesai,
            'tahun_anggaran' => $this->tahun_anggaran,
            'target_jumlah_hasil' => $this->target_jumlah_hasil,
            'target_waktu_pelaksanaan' => $this->target_waktu_pelaksanaan,
            'type' => $this->type,
            'unit_id' => $this->unit_id,
            'updated_at' => $this->updated_at,

            $this->mergeWhen($request->withCan && $request->user(), [
                // 'can' => [
                //     'view' => $request->user()?->hasPermissionTo('programKegiatan.view') || $request->user()?->id == $this->user_id,
                //     'update' => $request->user()?->hasPermissionTo('programKegiatan}}.update') || $request->user()?->id == $this->user_id,
                //     'delete' => $request->user()?->hasPermissionTo('programKegiatan.delete') || $request->user()?->id == $this->user_id,
                //     'restore' => $request->user()?->hasPermissionTo('programKegiatan.restore'),
                //     'forceDelete' => $request->user()?->hasPermissionTo('programKegiatan.forceDelete'),
                // ]
            ]),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'success' => true,
            'message' => $this->message,
            'meta' => null,
            'errors' => null
        ];
    }
}
