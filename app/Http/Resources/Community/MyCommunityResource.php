<?php

namespace App\Http\Resources\Community;

use App\Models\Community;
use Illuminate\Http\Resources\Json\JsonResource;

class MyCommunityResource extends JsonResource
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
            'community' => Community::where('id', $this->community_id)->get()
        ];
    }
}
