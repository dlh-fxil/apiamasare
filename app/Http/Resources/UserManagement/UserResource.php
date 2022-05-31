<?php

namespace App\Http\Resources\UserManagement;

use App\Http\Resources\Media\ImageResource;
use App\Http\Resources\Kepegawaian\UnitResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Kepegawaian\JabatanResource;
use App\Http\Resources\Kepegawaian\PangkatResource;
use App\Http\Resources\Kepegawaian\SubUnitResource;

class UserResource extends JsonResource
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
        $avatar = null;
        try {
            $avatar = $this->getMedia('avatar')[0];
        } catch (\Throwable $th) {
            $avatar = null;
        }
        return [
            'id' => $this->id,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'jenis_pegawai' => $this->jenis_pegawai,
            'nama' => $this->name,
            'nip' => $this->nip,
            'no_hp' => $this->no_hp,
            'no_wa' => $this->no_wa,
            'eselon' => $this->eselon,
            'unit_id' => $this->unit_id,
            'jabatan_id' => $this->jabatan_id,
            'sub_unit_id' => $this->sub_unit_id,
            'pangkat_id' => $this->pangkat_id,
            'permissions' =>  PermissionResource::collection($this->whenNotNull($this->whenLoaded('permissions'))),
            'unit' => new UnitResource($this->whenNotNull($this->whenLoaded('unit'))),
            'pangkat' => new PangkatResource($this->whenNotNull($this->whenLoaded('pangkat'))),
            'jabatan' => new JabatanResource($this->whenNotNull($this->whenLoaded('jabatan'))),
            'subUnit' => new SubUnitResource($this->whenNotNull($this->whenLoaded('subUnit'))),
            'roles' =>  RoleResource::collection($this->whenNotNull($this->whenLoaded('roles'))),
            'profile_images' => new ImageResource($avatar ?? null),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            $this->mergeWhen($request->withCan && $request->user(), [
                'can' => [
                    'view' => $request->user()->hasPermissionTo('users.view') || $request->user()->id == $this->user_id,
                    'update' => $request->user()->hasPermissionTo('users.update') || $request->user()->id == $this->user_id,
                    'delete' => $request->user()->hasPermissionTo('users.delete') || $request->user()->id == $this->user_id,
                    'restore' => $request->user()->hasPermissionTo('users.restore'),
                    'forceDelete' => $request->user()->hasPermissionTo('users.forceDelete'),
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
