<?php

namespace App\Livewire;

use App\Events\StartGameEvent;
use App\Models\Lobby;
use Livewire\Attributes\On;
use Livewire\Component;

class LobbyComponent extends Component
{
    public $lobby;

    public $data;

    public function mount($joining_code)
    {
        $this->lobby = Lobby::where('joining_code', $joining_code)->firstOrFail();
        $this->data = cache()->get('game_data_'.$this->lobby->joining_code);
    }

    public function render()
    {
        return view('livewire.lobby-component');
    }

    public function redirectToGame()
    {
        StartGameEvent::dispatch();
        //$this->redirect(route('play.game',['joining_code' => $this->lobby->joining_code]));
    }

    #[On('echo:tic-tac-toe-channel,SyncPlayersEvent')]
    public function syncPlayer()
    {
        $this->data = cache()->get('game_data_'.$this->lobby->joining_code);
    }

    #[On('echo:tic-tac-toe-channel,StartGameEvent')]
    public function startGame()
    {
        $this->redirect(route('play.game', ['joining_code' => $this->lobby->joining_code]));
    }
}
