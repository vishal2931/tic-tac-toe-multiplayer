<div>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-400 via-pink-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-1">Tic Tac Toe</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-1">Lobby : {{ $lobby->name }}</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-1">Player 1 : {{ $data['players'][0]->name }}</h1>
            <h1 class="text-center text-lg font-bold text-gray-800 mb-8">Player 2 : {{ $data['players'][1]->name }}</h1>
            <div class="grid grid-cols-3 gap-4">
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(1)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(2)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(3)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(4)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(5)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(6)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(7)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(8)"></div>
                <div class="border-4 border-cyan-300 h-40 w-40 flex items-center justify-center cursor-pointer" wire:click="makeMove(9)"></div>
            </div>
        </div>
    </div>
</div>
