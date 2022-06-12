<?php

namespace App\Http\Resources\UserManagement;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'group' => $this->group,
            'name' => $this->name,
            'description' => $this->description,
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,


            $this->mergeWhen($request->withCan && $request->user(), [
                'can' => [
                    'view' => $request->user()->hasPermissionTo('permissions.view') || $request->user()->id == $this->user_id,
                    'update' => $request->user()->hasPermissionTo('permissions.update') || $request->user()->id == $this->user_id,
                    'delete' => $request->user()->hasPermissionTo('permissions.delete') || $request->user()->id == $this->user_id,
                    'restore' => $request->user()->hasPermissionTo('permissions.restore'),
                    'forceDelete' => $request->user()->hasPermissionTo('permissions.forceDelete'),
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
