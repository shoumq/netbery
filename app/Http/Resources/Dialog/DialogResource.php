<?php

namespace App\Http\Resources\Dialog;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DialogResource extends JsonResource
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
            'user_one' => User::where('id', $this->user_one)->get()[0]->name . ' ' . User::where('id', $this->user_one)->get()[0]->surname,
            'user_two' => User::where('id', $this->user_two)->get()[0]->name . ' ' . User::where('id', $this->user_two)->get()[0]->surname,
            'user_one_id' => User::where('id', $this->user_one)->get()[0]->id,
            'user_two_id' => User::where('id', $this->user_two)->get()[0]->id,
            'user_one_login' => User::where('id', $this->user_one)->get()[0]->login,
            'user_two_login' => User::where('id', $this->user_two)->get()[0]->login,
        ];
    }
}

//return [
//    'id' => $this->id,
//    'name_one' => User::where('id', $this->user_one)->get()[0]->name . ' ' . User::where('id', $this->user_one)->get()[0]->surname,
//    'name_two' => User::where('id', $this->name_two)->get()[0]->name . ' ' . User::where('id', $this->name_two)->get()[0]->surname,
//];
