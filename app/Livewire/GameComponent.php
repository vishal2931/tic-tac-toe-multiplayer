<?php

namespace App\Livewire;

use App\Models\Lobby;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class GameComponent extends Component
{
    public $lobby;

    public $data;
    
    public $moves;

    public $player_1_sign = 'O';

    public $player_2_sign = 'X';

    public $player_moves = [];

    public $possibilities = [
        [1, 2, 3],
        [1, 4, 7],
        [7, 8, 9],
        [3, 6, 9],
        [4, 5, 6],
        [2, 5, 8],
        [1, 5, 9],
        [3, 5, 7],
    ];

    public function mount($joining_code)
    {
        $this->lobby = Lobby::where('joining_code', $joining_code)->firstOrFail();
        $this->data = cache()->get('game_data_'.$this->lobby->joining_code);

    }

    public function render()
    {
        return view('livewire.game-component');
    }

    public function makeMove($index)
    {
                

    }
}
