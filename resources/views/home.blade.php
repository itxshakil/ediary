@extends('layouts.app')
@section('title')
Dashboard | Read and write your diary
@endsection
@section('content')
<div class="container mx-auto px-3 md:px-6">
    <diaries></diaries>
    <div class="bg-blue-700 text-white p-4 rounded max-w-72 fixed bottom-0 mb-4 mr-4 max-w-lg hidden transition-all duration-200 ease-in" id="install-snackbar">
        <h3 class="pb-2 font-semibold text-lg tracking-wide">Install</h3>
        <div class="flex justify-between gap-2 items-start">
            <p>Installing uses almost no storage and provides a quick way to return to this app.</p>
            <button onclick="window.showInstallPromotion()" class="bg-white text-blue-700 px-2 py-1 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs">Install</button>
        </div>
    </div>
</div>
@endsection
