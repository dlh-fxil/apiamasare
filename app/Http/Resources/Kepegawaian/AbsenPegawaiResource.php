<?php

namespace App\Http\Resources\Kepegawaian;

use Illuminate\Http\Resources\Json\JsonResource;

class AbsenPegawaiResource extends JsonResource
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
   'jenis_pegawai' => $this->jenis_pegawai,
   'nama' => $this->nama,
   'nip' => $this->nip,
   'no_hp' => $this->no_hp,
   'no_wa' => $this->no_wa,
   'eselon' => $this->eselon,
   'unit' => new UnitResource($this->whenNotNull($this->whenLoaded('unit'))),
   'pangkat' => $this->whenNotNull($this->whenLoaded('pangkat')),
   'jabatan' => $this->whenNotNull($this->whenLoaded('jabatan')),
   'subUnit' => new SubUnitResource($this->whenNotNull($this->whenLoaded('subUnit'))),
   'user' => $this->whenNotNull($this->whenLoaded('user')),
   'pangkat' => $this->whenNotNull($this->whenLoaded('pangkat')),
   'jabatan' => $this->whenNotNull($this->whenLoaded('jabatan')),
   'subUnit' => new SubUnitResource($this->whenNotNull($this->whenLoaded('subUnit'))),
   'absen' => new AbsenResource($this->whenNotNull($this->whenLoaded('absen')))
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
