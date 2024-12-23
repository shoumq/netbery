<?php

namespace App\Http\Resources\Community;

use App\Models\Community;
use App\Models\Community_subscriber;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
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
//            'communities' => Community::where('id', $this->id)->get(),
            'communities' => Community::where('id', $this->community_id)->get(),
            'users' => User::where('id', $this->user_id)->get(),
        ];
    }
}
