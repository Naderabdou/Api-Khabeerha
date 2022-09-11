<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'ID_number'=> $this->ID_number,
            'phone'=>$this->phone ,
            'email'=> $this->email,
            'order_count'=>$this->order_count,
            'order_services'=>$this->order_services,
 
 


           



        ];
    }
}
