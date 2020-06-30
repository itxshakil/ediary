@extends('layouts.app')
@section('title','Ediary')
@section('content')
<div class="flex flex-col justify-center items-center h-screen px-3 md:px-6 bg-blue-700">
    <h2 class="text-gray-200 text-2xl hidden md:block md:text-4xl text-center">Securely write and save your private
        Diary</h2>
    <p class="text-gray-200 text-xl md:text-2xl mb-4 text-center">Your diary is your only friend, with whom you can share all your secrets and thoughts.</p>
    @guest
        <register-form></register-form>
    @endguest
</div>
@endsection