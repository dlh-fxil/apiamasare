<?php

namespace App\Http\Resources\Kepegawaian;

use Illuminate\Http\Resources\Json\JsonResource;

class UraianTugasResource extends JsonResource
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
            'id' => $this->id,
            'jabatan_id' => $this->jabatan_id,
            'jenis_tugas' => $this->jenis_tugas,
            'uraian_tugas' => $this->uraian_tugas,
            'indikator' => $this->indikator,
            'angka_kredit' => $this->angka_kredit,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            $this->mergeWhen($request->withCan && $request->user(), [
                'can' => [
                    'view' => $request->user()?->hasPermissionTo('uraianTugas.view') || $request->user()?->id == $this->user_id,
                    'update' => $request->user()?->hasPermissionTo('uraianTugas.update') || $request->user()?->id == $this->user_id,
                    'delete' => $request->user()?->hasPermissionTo('uraianTugas.delete') || $request->user()?->id == $this->user_id,
                    'restore' => $request->user()?->hasPermissionTo('uraianTugas.restore'),
                    'forceDelete' => $request->user()?->hasPermissionTo('uraianTugas.forceDelete'),
                ]
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
