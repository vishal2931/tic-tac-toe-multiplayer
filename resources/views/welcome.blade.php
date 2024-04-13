@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-400 via-pink-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-8">Tic Tac Toe</h1>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('lobby.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Lobby
                </a>
                <a href="{{ route('lobby.join') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Join Lobby
                </a>
            </div>
        </div>
    </div>
@endsection
