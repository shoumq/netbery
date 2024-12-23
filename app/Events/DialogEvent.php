<?php

namespace App\Events;

use App\Http\Resources\Dialog\DialogResource;
use App\Models\Dialog;
use App\Models\Like;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DialogEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Dialog $dialog;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Dialog $dialog)
    {

        $this->dialog = $dialog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('dialog_channel');
    }


    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'dialog_channel';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'dialog' => DialogResource::make($this->dialog)->resolve()
        ];
    }
}
