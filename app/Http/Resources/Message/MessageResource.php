<?php

namespace App\Http\Resources\Message;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'name' => $this->from_name,
            'surname' => User::where('id', $this->from_id)->get()[0]->surname,
            'login' => User::where('id', $this->from_id)->get()[0]->login,
            'id' => $this->id,
            'user_id' => $this->from_id,
            'body' => $this->body,
            'time' => date($this->created_at),
        ];
    }
}
