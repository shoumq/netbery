<?php

namespace App\Http\Resources\Community;

use App\Models\Community;
use App\Models\Community_like;
use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostCommunityResource extends JsonResource
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
            'id' => $this->id,
            'community_title' => Community::where('id', $this->community_id)->first()->title,
            'body' => $this->body,
            'time' => date($this->created_at),
            'likes' => count(Community_like::where('post_id', $this->id)->get()),
            'your_like' => count(Community_like::where('post_id', $this->id)
                ->where('from_id', Auth::user()->id)
                ->get())
        ];
    }
}
