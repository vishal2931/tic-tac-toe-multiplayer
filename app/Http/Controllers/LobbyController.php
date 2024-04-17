<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Player;
use App\Models\Lobby;
use App\Http\Requests\LobbyStoreRequest;
use App\Http\Requests\LobbyJoinRequest;
use App\Events\SyncPlayersEvent;

class LobbyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lobby.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LobbyStoreRequest $request)
    {
        $lobby = Lobby::create([
            'name' => $request->lobby_name,
            'joining_code' => fake()->randomNumber(config('custom.joining_code_length')),
        ]);

        $player = Player::create([
            'name' => $request->player_name,
            'lobby_id' => $lobby->id,
        ]);

        Cache::put('game_data_'.$lobby->joining_code, [
            'lobby' => $lobby,
            'players' => collect([$player]),
            'creator' => $player->id,
        ]);
        session()->put('player', $player->id);

        return redirect()->route('lobby.area', ['joining_code' => $lobby->joining_code]);
    }

    public function join()
    {
        return view('lobby.join');
    }

    public function join_post(LobbyJoinRequest $request)
    {
        $lobby = Lobby::where('joining_code', $request->joining_code)->first();
        if (! $lobby) {
            return redirect()->back()->withErrors(['joining_code' => 'Invalid joining code.']);
        }

        $player = Player::create([
            'lobby_id' => $lobby->id,
            'name' => $request->player_name,
        ]);

        $data = cache()->get('game_data_'.$lobby->joining_code);
        $data['players']->push($player);
        Cache::put('game_data_'.$lobby->joining_code, $data);
        session()->put('player', $player->id);
        SyncPlayersEvent::dispatch();

        return redirect()->route('lobby.area', ['joining_code' => $lobby->joining_code])->with('join', 'success');
    }
}
