<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    { return
     [
        'id'=>$this->id,
        'name_main'=>$this->name_main,
        'name_sub'=>$this->name_sub,
        'desc'=>$this->desc,
        'code_order'=>$this->code_order,
        'from'=>$this->from,
        'to'=>$this->to,
        'GBS'=>$this->GBS,
        'file'=>$this->file,
        'user_id'=>$this->user_id,
    ];
    }
}
