<?php

namespace App\Http\Resources\Images;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        Carbon::setLocale('ru');
        
        return [
            'name' => $this->name,
            'size' => $this->size,
            'user_id' => $this->user_id,
            'id' => $this->id,
            'time' => $this->created_at->diffForHumans()
        ];
    }
}
