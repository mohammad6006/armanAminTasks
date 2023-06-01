<?php

namespace App\Events;

use App\Models\TableA;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableACreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tableA;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TableA $tableA)
    {
        $this->tableA = $tableA;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
