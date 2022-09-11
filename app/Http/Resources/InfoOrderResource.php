<?php

namespace App\Http\Resources;
use App\Models\User;


use Illuminate\Http\Resources\Json\JsonResource;

class InfoOrderResource extends JsonResource
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
                'status'=>$this->pivot->status,
                'price'=>$this->pivot->price,
                'username'=> User::find($this->pivot->user_id)->first_name,
                'phone'=> User::find($this->pivot->user_id)->phone,
                'email'=> User::find($this->pivot->user_id)->email
        
        
        
        
               
        
        
        
            ];
        
        
 
    }
}
