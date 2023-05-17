<?php

namespace App\Http\Resources\Community;

use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersCommunityResource extends JsonResource
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
            'users' => User::where('id', $this->user_id)->get()
        ];
    }
}
