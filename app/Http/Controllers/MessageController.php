<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Dialog\DialogResource;
use App\Http\Resources\Message\MessageResource;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $dialogs = Dialog::where('user_one', Auth::user()->id)
            ->orWhere('user_two', Auth::user()->id)->get();
        $dialogs = DialogResource::collection($dialogs)->resolve();
        return inertia('Dialogs', compact('dialogs'));
    }

    public function chat(Dialog $dialog_id)
    {
        $dialog = DialogResource::collection(Dialog::where('id', $dialog_id->id)->get())->resolve();
        if (($dialog[0]['user_one_id'] == Auth::user()->id) or ($dialog[0]['user_two_id'] == Auth::user()->id)) {
            $messages = MessageResource::collection(Message::where('dialog_id', $dialog_id->id)->get())->resolve();
            return inertia('Chat', compact('messages', 'dialog'));
        } else {
            return redirect('/messages');
        }
    }

    public function store(Dialog $dialog_id, StoreRequest $request)
    {
        $message = new Message;
        $message->from_name = Auth::user()->name;
        $message->from_id = Auth::user()->id;
        $message->dialog_id = $dialog_id->id;
        $message->body = $request->body;
        $message->save();

        event(new StoreMessageEvent($message));

        return MessageResource::make($message)->resolve();
    }

    public function createDialog(Request $request)
    {
        $ddialog = Dialog::where('user_one', Auth::user()->id)
            ->where('user_two', $request->id)
            ->orWhere('user_one', $request->id)
            ->where('user_two', Auth::user()->id)->get();

        if (count($ddialog) == 0) {
            $dialog = new Dialog;
            $dialog->user_one = Auth::user()->id;
            $dialog->user_two = $request->id;
            $dialog->save();

            return $dialog->id;
        } else {
            return $ddialog[0]['id'];
        }
    }
}
