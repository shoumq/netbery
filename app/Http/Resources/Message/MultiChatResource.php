<?php

namespace App\Http\Resources\Message;

use App\Models\MultiChat;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MultiChatResource extends JsonResource
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
            'multi_chat_id' => $this->multi_chat_id,
            'multi_chat_title' => MultiChat::where('id', $this->multi_chat_id)->first()->dialog_title,
            'multi_chat_img' => MultiChat::where('id', $this->multi_chat_id)->first()->img_name
        ];
    }
}
