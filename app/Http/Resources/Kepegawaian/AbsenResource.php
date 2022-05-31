<?php

namespace App\Http\Resources\Kepegawaian;

use App\Http\Resources\UserManagement\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AbsenResource extends JsonResource
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
            'tahun' => $this->tahun,
            'tanggal' => $this->tanggal,
            // 'tanggal' => $this->tanggal ? strtotime($this->tanggal) : null,
            'istirahat' => $this->istirahat,
            'masuk_kantor' => $this->masuk_kantor,
            'selesai_istirahat' => $this->masuk_istirahat,
            'pulang_kantor' => $this->pulang_kantor,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'pegawai' => new PegawaiResource($this->whenNotNull($this->whenLoaded('pegawai'))),
            'user_id' => new UserResource($this->whenNotNull($this->whenLoaded('user'))),

            $this->mergeWhen($request->withCan && $request->user(), [
                'can' => [
                    'view' => $request->user()?->hasPermissionTo('absen.view') || $request->user()?->id == $this->user_id,
                    'update' => $request->user()?->hasPermissionTo('absen.update') || $request->user()?->id == $this->user_id,
                    'delete' => $request->user()?->hasPermissionTo('absen.delete') || $request->user()?->id == $this->user_id,
                    'restore' => $request->user()?->hasPermissionTo('absen.restore'),
                    'forceDelete' => $request->user()?->hasPermissionTo('absen.forceDelete'),
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
