<?php

namespace App\Events;

use App\Http\Resources\Message\MessageBroadcastResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageStatusStoreEvent implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    public function __construct(
        private readonly int $count,
        private readonly int $chatId,
        private readonly int $userId,
    )
    {}
    public function broadcastOn(): array
    {
        return [
            new Channel('users.' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'store-message-status';
    }

    public function broadcastWith(): array
    {
        return [
            'chat_id' => $this->chatId,
            'count' => $this->count
        ];
    }
}
