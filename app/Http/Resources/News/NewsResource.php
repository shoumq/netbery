<?php

namespace App\Http\Resources\News;

use App\Models\Community;
use App\Models\Community_post;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'posts' => Community_post::where('community_id', $this->community_id)->get(),
            'community' => Community::where('id', $this->community_id)->get(),
        ];
    }
}
