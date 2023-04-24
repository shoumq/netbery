<?php

namespace App\Events;

use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StorePrivateMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Message $message;
    private int $from_user;
    private int $to_user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message, int $from_user, int $to_user)
    {
        //
        $this->message = $message;
        $this->from_user = $from_user;
        $this->to_user = $to_user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('send_message_' . $this->from_user . '_' . $this->to_user);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'send_message';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'message' => MessageResource::make($this->message)->resolve()
        ];
    }
}
