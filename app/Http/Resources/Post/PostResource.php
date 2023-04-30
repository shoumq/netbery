<?php

namespace App\Http\Resources\Post;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'body' => $this->body,
            'time' => date($this->created_at),
            'likes' => count(Like::where('post_id', $this->id)->get()),
            'your_like' => count(Like::where('post_id', $this->id)
                ->where('from_id', Auth::user()->id)
                ->get())
        ];
    }
}
