<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Lobby;
use App\Events\StartGameEvent;

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
