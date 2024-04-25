<div>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 via-red-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-1">Tic Tac Toe</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-1">Lobby : {{ $lobby->name }}</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-1">Player 1 : {{ $data['players'][0]->name }}</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-1">Player 2 : {{ $data['players'][1]->name }}</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-8" wire:ignore>Player Turn : <span id="player-turn">Your Turn</span></h1>
            <div class="grid grid-cols-3 gap-4" id="game-board" wire:loading.class="pointer-events-none">
                @for ($i=1;$i<=9;$i++)
                    @if((!empty($player_moves[$data['players'][0]->id]) && in_array($i,$player_moves[$data['players'][0]->id])))
                        <div class="border-4 border-green-300 h-40 w-40 flex items-center justify-center cursor-pointer text-8xl text-black pointer-events-none">O</div>
                    @elseif(!empty($player_moves[$data['players'][1]->id]) && in_array($i,$player_moves[$data['players'][1]->id]))
                        <div class="border-4 border-green-300 h-40 w-40 flex items-center justify-center cursor-pointer text-8xl text-black pointer-events-none">X</div>
                    @else
                        <div class="border-4 border-green-300 h-40 w-40 flex items-center justify-center cursor-pointer text-8xl text-black" wire:click="makeMove({{ $i }})"></div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
    <div id="gameStatusModal" class="modal hidden fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center" wire:ignore>
        <div class="modal-content bg-white w-96 p-8 rounded-lg text-center">
            <span class="close-modal cursor-pointer absolute top-0 right-0 p-4">&times;</span>
            <h2 class="text-2xl font-bold mb-6">Tic Tac Toe</h2>
            <h2 class="text-1xl font-bold mb-4" id="modalMessage">Player 1 is the Winner</h2>
            @if(session('player') == $data['players'][0]->id)
                <button wire:click='playAgain()' class="bg-blue-500 text-white px-4 py-2 rounded-lg">Play Again</button>
            @endif
        </div>
    </div>
    @script
     <script>
            let player_id = {{ session("player")  }};
            let opposite_player_name = "{{ (session('player') == $data['players'][0]->id ? $data['players'][1]->name : $data['players'][0]->name) }}";
            $wire.on('game-status', (event) => {
                document.getElementById('gameStatusModal').classList.remove('hidden');
                if(event[0].status == 'win')
                {
                    document.getElementById('modalMessage').innerText = 'The winner is '+event[0].player.name;
                }
                else if(event[0].status == 'tie')
                {
                    document.getElementById('modalMessage').innerText = 'The game is tie';
                }
            });
                
            $wire.on('reset-game', (event) => {
                document.getElementById('gameStatusModal').classList.add('hidden');
                document.getElementById('modalMessage').innerText = '';
            });

            Echo.channel('tic-tac-toe-channel')
            .listen('PlayerTurnEvent', e => {
                if(player_id != e.player_turn_id)
                {
                    document.getElementById('game-board').classList.add('bg-red-400');
                    document.getElementById('player-turn').innerText = opposite_player_name + ' Turn';
                }else{
                    
                    document.getElementById('game-board').classList.remove('bg-red-400');
                    document.getElementById('player-turn').innerText = 'Your Turn';
                }
            })

        </script>

    @endscript
</div>
