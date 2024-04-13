@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-400 via-pink-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-8">Lobby</h1>
            <form action="{{ route('lobby.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="lobby_name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                    <input type="text" id="lobby_name" name="lobby_name" placeholder="Enter lobby name" class="border border-gray-300 rounded-md px-4 py-2 w-full text-black">
                    @error('lobby_name')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="player_name" class="block text-gray-700 text-sm font-bold mb-2">Your Name</label>
                    <input type="text" id="player_name" name="player_name" placeholder="Enter your name" class="border border-gray-300 rounded-md px-4 py-2 w-full text-black">
                    @error('player_name')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection