<?php

namespace App\Livewire;

use App\Events\GameProgressEvent;
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
        GameProgressEvent::dispatch([
            'action' => 'start-game',
            'joining_code' => $this->lobby->joining_code,
        ]);
    }

    #[On('echo:tictactoechannel.{lobby.joining_code},GameProgressEvent')]
    public function eventListener($data)
    {
        if ($data['action'] == 'sync-player') {
            $this->data = cache()->get('game_data_'.$this->lobby->joining_code);
        } elseif ($data['action'] == 'start-game') {
            $this->redirect(route('play.game', ['joining_code' => $this->lobby->joining_code]));
        }
    }
}
