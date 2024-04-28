<div>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-400 via-red-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-3">Waiting Area</h1>
            <h1 class="text-center text-2xl font-bold text-gray-800 mb-8">Joining Code : {{ $lobby->joining_code }}</h1>
            <div class="mb-4">
                <p class="text-center text-lg font-bold text-gray-700 mb-4">Players:</p>
                <div class="flex justify-between items-center bg-gray-100 p-4 rounded-lg mb-4">
                    @if(isset($data['players']))
                        <span class="text-lg font-bold text-gray-700">{{ $data['players'][0]->name }}</span>
                        <span class="text-lg font-bold text-gray-700">vs</span>
                        <span class="text-lg font-bold text-gray-700">{{ $data['players'][1]->name ?? 'Waiting for player to join...' }}</span>
                    @endif
                </div>
            </div>
            @if(session('player') == $data['players'][0]->id)
                <div class="flex justify-center">
                    <button wire:click='redirectToGame()' class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:bg-blue-300" @disabled($data['players']->count() !== 2)>Start Game</button>
                </div>
            @else
                <div class="flex justify-center">
                    <h1 class="text-black animate-pulse">Waiting for start the game....</h1>
                </div>
            @endif

        </div>
    </div>
</div>
