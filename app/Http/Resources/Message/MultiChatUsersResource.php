<?php

namespace App\Http\Resources\Message;

use App\Models\MultiChat;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MultiChatUsersResource extends JsonResource
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
            'user_id' => User::where('id', $this->user_id)->first()->id,
            'user_name' => User::where('id', $this->user_id)->first()->name,
            'user_surname' => User::where('id', $this->user_id)->first()->surname,
            'user_img' => User::where('id', $this->user_id)->first()->img_id,
        ];
    }
}
