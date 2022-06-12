<?php

namespace App\Http\Resources\Kegiatan;

use App\Http\Resources\Kepegawaian\UnitResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Kepegawaian\PegawaiResource;
use App\Http\Resources\UserManagement\UserResource;
use App\Http\Resources\Kepegawaian\UraianTugasResource;

class KegiatanResource extends JsonResource
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
        $users = collect($this->users);
        $ids = $users->pluck('id')->toArray();
        return [
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'createdBy' => new UserResource(($this->whenNotNull($this->whenLoaded('createdBy')))),
            'deleted_at' => $this->deleted_at,
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'tahun' => $this->tahun,
            'images' => null,
            'judul' => $this->judul,
            'mulai' => $this->mulai,
            'program_kegiatan_id' => $this->program_kegiatan_id,
            'programKegiatan' => new ProgramKegiatanResource(($this->whenNotNull($this->whenLoaded('programKegiatan')))),
            'selesai' => $this->selesai,
            'unit_id' => $this->unit_id,
            'unit' => new UnitResource(($this->whenNotNull($this->whenLoaded('unit')))),
            'units' => UnitResource::collection(($this->whenNotNull($this->whenLoaded('units')))),
            'updated_at' => $this->updated_at,
            'uraian' => $this->uraian,
            'uraianTugas' => UraianTugasResource::collection(($this->whenNotNull($this->whenLoaded('uraianTugas')))),
            'users' => UserResource::collection(($this->whenNotNull($this->whenLoaded('users')))),

            $this->mergeWhen($request->user(), [
                'can' => [
                    'follow' => !in_array($request->user()->id, $ids) && !$this->selesai,
                    'unfollow' => in_array($request->user()->id, $ids),
                    'end' => !$this->selesai,
                    'cancelEnd' => $this->selesai && $request->user()->id == $this->created_by
                    // 'view' => $request->user()?->hasPermissionTo('kegiatan.view') || $request->user()?->id == $this->user_id,
                    // 'view' => $request->user()?->hasPermissionTo('kegiatan.view') || $request->user()?->id == $this->user_id,
                    // 'update' => $request->user()?->hasPermissionTo('kegiatan}}.update') || $request->user()?->id == $this->user_id,
                    // 'delete' => $request->user()?->hasPermissionTo('kegiatan.delete') || $request->user()?->id == $this->user_id,
                    // 'restore' => $request->user()?->hasPermissionTo('kegiatan.restore'),
                    // 'forceDelete' => $request->user()?->hasPermissionTo('kegiatan.forceDelete'),
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
