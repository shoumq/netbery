<?php

namespace App\Http\Controllers;

use App\Events\StoreMessageEvent;
use App\Events\StoreMultiChatMessEvent;
use App\Http\Requests\Message\StoreRequest;
use App\Http\Resources\Dialog\DialogResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Message\MultiChatMessResource;
use App\Http\Resources\Message\MultiChatResource;
use App\Http\Resources\Message\MultiChatUsersResource;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\MultiChat;
use App\Models\MultiChatMess;
use App\Models\MultiChatUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function index()
    {
        $cols = collect();

        $dialogs = Dialog::where('user_one', Auth::user()->id)
            ->orWhere('user_two', Auth::user()->id)->get();
        $dialogs = DialogResource::collection($dialogs)->resolve();

        $multi_chats = MultiChatUsers::where('user_id', Auth::user()->id)->get();
        $multi_chats = MultiChatResource::collection($multi_chats)->resolve();

        $dialogs_id = $dialogs;

        if ($dialogs != null) {
            foreach ($dialogs as $sc) {
                $cols->add($sc);
            }
        }
        if ($multi_chats != null) {
            foreach ($multi_chats as $mc) {
                $cols->add($mc);
            }
        }

        $col = $cols->sortByDesc('updated_at', SORT_NATURAL)->values()->all();

//        event(new DialogEvent($dialogs->id));

        return inertia('Dialogs', compact('dialogs', 'dialogs_id', 'multi_chats', 'col'));
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

    public function mchat(MultiChat $dialog_id)
    {
        $isYour = MultiChatUsers::where('multi_chat_id', $dialog_id->id)
            ->where('user_id', Auth::user()->id)->get();

        if (count($isYour) === 1) {
            $messages = MultiChatMess::where('multi_chat_id', $dialog_id->id)->get();
            $messages = MultiChatMessResource::collection($messages)->resolve();

            $users = MultiChatUsers::where('multi_chat_id', $dialog_id->id)->get();
            $users = MultiChatUsersResource::collection($users)->resolve();

            $users_count = count(MultiChatUsers::where('multi_chat_id', $dialog_id->id)->get());

            return inertia('MChat', compact('dialog_id', 'messages', 'users', 'users_count'));
        } else {
            return to_route('messages');
        }
    }

    public function renderCreateMultiDialog()
    {
        return inertia('CreateDialog');
    }

    public function createMultiDialog(Request $request)
    {
        $name = $request->file('file')->getClientOriginalName();
        $size = $request->file('file')->getSize();

        $request->file('file')->storeAs('public/images/', $name);

        $multi_chat = new MultiChat();
        $multi_chat->dialog_title = $request->dialog_title;
        $multi_chat->img_name = $name;
        $multi_chat->img_size = $size;
        $multi_chat->admin_id = Auth::user()->id;
        $multi_chat->save();

        $multi_chat_users = new MultiChatUsers();
        $multi_chat_users->multi_chat_id = $multi_chat->id;
        $multi_chat_users->user_id = Auth::user()->id;
        $multi_chat_users->save();

        return $request;
    }

    public function store(Dialog $dialog_id, StoreRequest $request)
    {
        $message = new Message();
        $message->from_name = Auth::user()->name;
        $message->from_id = Auth::user()->id;
        $message->dialog_id = $dialog_id->id;
        $message->body = $request->body;
        $message->save();

        $dialogs_id = Dialog::find($dialog_id->id);
        $dialogs_id->updated_at = Carbon::now();
        $dialogs_id->save();

        event(new StoreMessageEvent($message, $dialog_id->id));

        return MessageResource::make($message)->resolve();
    }

    public function storeMchat(Request $request)
    {
        $message = new MultiChatMess();
        $message->multi_chat_id = $request->multi_chat_id;
        $message->user_id = Auth::user()->id;
        $message->body = $request->body;
        $message->save();

        $dialogs_id = MultiChat::find($request->multi_chat_id);
        $dialogs_id->updated_at = Carbon::now();
        $dialogs_id->save();

        event(new StoreMultiChatMessEvent($message, $request->multi_chat_id));

        return MultiChatMessResource::make($message)->resolve();
    }

    public function mchatChangeTitle(Request $request)
    {
        $chat = MultiChat::find($request->chat_id);
        $chat->dialog_title = $request->chat_title;
        $chat->save();

        return $chat;
    }

    public function searchUser(Request $request)
    {
        $user_nick = explode(' ', $request->name);

        if (count($user_nick) == 1) {
            $users = User::where('name', 'LIKE', '%' . $user_nick[0] . '%')->get();
        } elseif (count($user_nick) == 2) {
            $users = User::where('name', 'LIKE', '%' . $user_nick[0] . '%')
                ->where('surname', 'LIKE', '%' . $user_nick[1] . '%')->get();
        }

        return $users;
    }

    public function multiDialogKick(int $dialog_id, Request $request)
    {
        $chat = MultiChatUsers::where('multi_chat_id', $dialog_id)
            ->where('user_id', $request->user_id)->first();
        $chat->delete();

        return "success";
    }

    public function multiDialogAdd(int $dialog_id, Request $request)
    {
        if (count(MultiChatUsers::where('multi_chat_id', $dialog_id)->where('user_id', $request->user_id)->get()) == 0) {
            $chat = new MultiChatUsers();
            $chat->multi_chat_id = $dialog_id;
            $chat->user_id = $request->user_id;
            $chat->save();

            $user = MultiChatUsersResource::make($chat)->resolve();

            return $user;
        } else {
            return "already_exits";
        }
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

    public function filter(Request $request) {
        $fullCommand = './mlstruct ' . $request->input('text');
        $output = shell_exec($fullCommand);
        return response()->json((bool)$output);
    }
}
