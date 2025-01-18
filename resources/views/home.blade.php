@extends('layouts.app')
@section('title')
Dashboard | Read and write your diary
@endsection
@section('content')
<div class="container mx-auto px-3 md:px-6 my-4">
    <diaries></diaries>
    <div class="d-flex flex-col gap-4 max-w-72 fixed bottom-0 mb-4 mr-4 max-w-lg transition-all duration-200 ease-in">
        <div class="bg-blue-700 text-white p-4 rounded w-full hidden" id="install-snackbar">
            <h3 class="pb-2 font-semibold text-lg tracking-wide">Install</h3>
            <div class="flex justify-between gap-2 items-start">
                <p>Installing uses almost no storage and provides a quick way to return to this app.</p>
                <button onclick="window.showInstallPromotion()" class="bg-white text-blue-700 px-2 py-1 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs">Install</button>
            </div>
        </div>
        <div id="notification-snackbar" class="bg-blue-700 text-white p-4 rounded w-full hidden" role="alert" aria-live="assertive" aria-hidden="true">
            <h3 class="pb-2 font-semibold text-lg tracking-wide">Enable Notifications</h3>
            <div class="flex justify-between gap-2 items-start">
                <p class="text-sm">Allow notifications to receive important updates and reminders for this app.</p>
                <button onclick="requestNotificationPermission()" class="bg-white text-blue-700 px-2 py-1 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs">Enable</button>
            </div>
        </div>
    </div>
</div>
@endsection
