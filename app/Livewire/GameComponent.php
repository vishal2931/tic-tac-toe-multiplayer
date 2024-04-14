<?php

namespace App\Livewire;

use App\Events\GameMovesEvent;
use App\Events\ResetGameEvent;
use App\Models\Lobby;
use Livewire\Attributes\On;
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
        GameMovesEvent::dispatch($index, session('player'));
    }

    #[On('echo:tic-tac-toe-channel,GameMovesEvent')]
    public function registerMove($data)
    {
        $this->moves[] = $data['index'];
        $this->player_moves[$data['player']][] = $data['index'];
        if(count($this->moves) > 4)
        {
            $this->checkForWin();
        }
    }

    public function checkForWin()
    {
        $winner = '';

        collect($this->possibilities)->each(function($value) use(&$winner){

            if(count(array_intersect($value, $this->player_moves[$this->data['players'][0]->id])) == count($value))
            {
                $winner = $this->data['players'][0];
                return;
            }
            else if(count(array_intersect($value, $this->player_moves[$this->data['players'][1]->id])) == count($value))
            {
                $winner = $this->data['players'][1];
                return;
            }
        });

        if($winner)
        {
            $this->dispatch('game-status',["status" => 'win','player'=>$winner]);
        }
        else if(count($this->moves) == 9)
        {
            $this->dispatch('game-status',["status" => 'tie']);
        }
    }

    public function playAgain()
    {
        ResetGameEvent::dispatch();
    }

    #[On('echo:tic-tac-toe-channel,ResetGameEvent')]
    public function resetGame()
    {
        $this->player_moves = [];
        $this->moves = [];
        $this->dispatch('reset-game');
    }
}
