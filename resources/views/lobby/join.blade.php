@extends('layouts.app')
@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-400 via-pink-500 to-red-500">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full md:w-1/2 lg:w-1/3">
            <h1 class="text-center text-4xl font-bold text-gray-800 mb-8">Join Lobby</h1>
            <form action="{{ route('lobby.join') }}"  method="POST">
                @csrf
                <div class="mb-4">
                    <label for="joining_code" class="block text-gray-700 text-sm font-bold mb-2">Joining Code</label>
                    <input type="text" id="joining_code" name="joining_code" placeholder="Enter joining code" class="border border-gray-300 rounded-md px-4 py-2 w-full text-black">
                    @error('joining_code')
                        <span class="text-red-600 font-semibold">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="player_name" class="block text-gray-700 text-sm font-bold mb-2">Player Name</label>
                    <input type="text" id="player_name" name="player_name" placeholder="Enter your name" class="border border-gray-300 rounded-md px-4 py-2 w-full text-black">
                    @error('player_name')
                        <span class="text-red-600 font-semibold">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">Join Lobby</button>
                </div>
            </form>
        </div>
    </div>
@endsection