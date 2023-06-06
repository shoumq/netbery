<?php

namespace App\Http\Resources\Message;

use App\Models\MultiChat;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MultiChatMessResource extends JsonResource
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
            'user_name' => User::where('id', $this->user_id)->first()->name,
            'user_surname' => User::where('id', $this->user_id)->first()->surname,
            'user_image' => User::where('id', $this->user_id)->first()->img_id,
            'body' => $this->body
        ];
    }
}
