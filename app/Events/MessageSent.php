<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $id_chatroom;
    public $id_user;
    public $message;

    public function __construct($id_chatroom, $id_user, $message)
    {
        $this->id_chatroom  = $id_chatroom;
        $this->id_user      = $id_user;
        $this->message      = $message;
    }

    public function broadcastOn()
    {
        return ['chat-room'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
