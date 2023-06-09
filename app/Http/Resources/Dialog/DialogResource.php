<?php

namespace App\Http\Resources\Dialog;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DialogResource extends JsonResource
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
            'type' => 'private',
//            'updated_at' => (int)explode(':', explode(' ', date($this->updated_at))[1])[2],
            'updated_at' => strtotime(date($this->updated_at)),
            'id' => $this->id,
            'user_one' => User::where('id', $this->user_one)->get()[0]->name . ' ' . User::where('id', $this->user_one)->get()[0]->surname,
            'user_two' => User::where('id', $this->user_two)->get()[0]->name . ' ' . User::where('id', $this->user_two)->get()[0]->surname,
            'user_one_id' => User::where('id', $this->user_one)->get()[0]->id,
            'user_two_id' => User::where('id', $this->user_two)->get()[0]->id,
            'user_one_login' => User::where('id', $this->user_one)->get()[0]->login,
            'user_two_login' => User::where('id', $this->user_two)->get()[0]->login,
            'user_one_img' => User::where('id', $this->user_one)->get()[0]->img_id,
            'user_two_img' => User::where('id', $this->user_two)->get()[0]->img_id,
            'last_message_body' => Message::where('dialog_id', $this->id)->latest('created_at')->get(),
            'isOnline' => ''
        ];
    }
}

//return [
//    'id' => $this->id,
//    'name_one' => User::where('id', $this->user_one)->get()[0]->name . ' ' . User::where('id', $this->user_one)->get()[0]->surname,
//    'name_two' => User::where('id', $this->name_two)->get()[0]->name . ' ' . User::where('id', $this->name_two)->get()[0]->surname,
//];
