<?php

namespace App\Http\Resources\Kepegawaian;

use Illuminate\Http\Resources\Json\JsonResource;

class JabatanResource extends JsonResource
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
            'jenis' => $this->jenis,
            'nama' => $this->nama,
            'kelas' => $this->kelas,
            'singkatan' => $this->singkatan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'uraianTugas' => $this->uraianTugas,

            $this->mergeWhen($request->withCan && $request->user(), [
                'can' => [
                    'view' => $request->user()?->hasPermissionTo('jabatan.view') || $request->user()?->id == $this->user_id,
                    'update' => $request->user()?->hasPermissionTo('jabatan.update') || $request->user()?->id == $this->user_id,
                    'delete' => $request->user()?->hasPermissionTo('jabatan.delete') || $request->user()?->id == $this->user_id,
                    'restore' => $request->user()?->hasPermissionTo('jabatan.restore'),
                    'forceDelete' => $request->user()?->hasPermissionTo('jabatan.forceDelete'),
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
