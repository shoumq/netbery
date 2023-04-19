<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index() {
        $messages = MessageResource::collection(Message::all())->resolve();
        return inertia('test', compact('messages'));
    }

    public function store(StoreRequest $request) {
        $message = new Message;
        $message->from_name = Auth::user()->name;
        $message->from_id = Auth::user()->id;
        $message->body = $request->body;
        $message->save();

        event(new StoreMessageEvent($message));

        return MessageResource::make($message)->resolve();
    }
}
