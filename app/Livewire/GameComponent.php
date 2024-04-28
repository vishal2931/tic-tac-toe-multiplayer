<?php

namespace App\Livewire;

use App\Events\GameProgressEvent;
use App\Models\Lobby;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class GameComponent extends Component
{
    public $lobby;

    public $data;

    public $moves;

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
        if (session('player') == $this->data['players'][0]['id']) {
            GameProgressEvent::dispatch([
                'action' => 'player-turn',
                'joining_code' => $this->lobby->joining_code,
                'player_turn_id' => session('player'),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.game-component');
    }

    public function makeMove($index)
    {
        $opposite_player_id = session('player') == $this->data['players'][0]->id ? $this->data['players'][1]->id : $this->data['players'][0]->id;

        GameProgressEvent::dispatch([
            'action' => 'game-moves',
            'joining_code' => $this->lobby->joining_code,
            'index' => $index,
            'player' => session('player'),
        ]);

        GameProgressEvent::dispatch([
            'action' => 'player-turn',
            'joining_code' => $this->lobby->joining_code,
            'player_turn_id' => $opposite_player_id,
        ]);
    }

    public function checkForWin()
    {
        $winner = null;

        foreach ($this->possibilities as $possibility) {
            if ($this->checkPlayerMoves($this->data['players'][0]->id, $possibility)) {
                $winner = $this->data['players'][0];
                break;
            } elseif ($this->checkPlayerMoves($this->data['players'][1]->id, $possibility)) {
                $winner = $this->data['players'][1];
                break;
            }
        }

        if ($winner) {
            $this->dispatch('game-status', ['status' => 'win', 'player' => $winner]);
        } elseif (count($this->moves) == 9) {
            $this->dispatch('game-status', ['status' => 'tie']);
        }

    }

    public function playAgain()
    {
        GameProgressEvent::dispatch([
            'action' => 'reset-game',
            'joining_code' => $this->lobby->joining_code,
        ]);
    }

    #[On('echo:tictactoechannel.{lobby.joining_code},GameProgressEvent')]
    public function eventListener($data)
    {
        if ($data['action'] == 'reset-game') {
            $this->player_moves = [];
            $this->moves = [];
            $this->dispatch('reset-game');
        } elseif ($data['action'] == 'game-moves') {
            $this->moves[] = $data['index'];
            $this->player_moves[$data['player']][] = $data['index'];
            if (count($this->moves) > 4) {
                $this->checkForWin();
            }
        }
    }

    private function checkPlayerMoves($playerId, $possibility)
    {
        return count(array_intersect($possibility, $this->player_moves[$playerId])) == count($possibility);
    }
}
