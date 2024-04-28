<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameProgressEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $index;

    public $player;

    public $joining_code;

    public $action;

    public $player_turn_id = '';

    /**
     * Create a new event instance.
     */
    public function __construct($data)
    {
        $this->action = $data['action'];
        $this->joining_code = $data['joining_code'];
        if ($data['action'] == 'game-moves') {
            $this->index = $data['index'];
            $this->player = $data['player'];
        } elseif ($data['action'] == 'player-turn') {
            $this->player_turn_id = $data['player_turn_id'];
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('tictactoechannel.'.$this->joining_code),
        ];
    }
}
