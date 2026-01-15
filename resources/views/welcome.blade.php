@extends('layouts.app')
@section('title','Ediary - Your Private Digital Journal')
@push('meta')
    @include('includes.meta')
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            let emailInput = document.getElementById("email");
            let usernameInput = document.getElementById("username");

            let typingTimer;
            const debounceDelay = 400; // ms

            const statusBox = document.createElement("div");
            statusBox.className = "mt-1 text-sm";
            usernameInput.parentNode.appendChild(statusBox);

            emailInput.addEventListener("input", function () {
                const email = this.value;
                const name = email.split("@")[0] || "";

                if (name.length > 3) {
                    usernameInput.value = name.toLowerCase().replace(/[^a-z0-9_]/g, "");
                    triggerUsernameCheck();
                }
            });

            usernameInput.addEventListener("input", () => {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(triggerUsernameCheck, debounceDelay);
            });

            function triggerUsernameCheck() {
                const username = usernameInput.value.trim();

                if (username.length < 4) {
                    statusBox.textContent = "Minimum 4 characters required";
                    statusBox.classList = 'mt-1 text-sm text-red-600';
                    return;
                }

                statusBox.textContent = "Checking...";
                statusBox.classList = 'mt-1 text-sm text-gray-500';

                axios.post("/api/check-username", { username })
                    .then(res => {
                        if (res.data.success) {
                            statusBox.textContent = "✔ Username available";
                            statusBox.classList = "mt-1 text-sm text-green-600";

                            usernameInput.classList.remove("border-red-500");
                            usernameInput.classList.add("border-green-500");
                        } else {
                            statusBox.textContent = "✖ Username already taken";
                            statusBox.classList = "mt-1 text-sm text-red-600";

                            usernameInput.classList.remove("border-green-500");
                            usernameInput.classList.add("border-red-500");
                        }

                    })
                    .catch(() => {
                        statusBox.textContent = "Error checking username";
                        statusBox.classList = "mt-1 text-sm text-red-600";
                    });
            }

        });
    </script>
@endpush

@section('content')

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white overflow-hidden">

        <!-- Subtle background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 md:pt-28 md:pb-32">

            <div class="text-center max-w-4xl mx-auto">

                <!-- Badge -->
                <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-2 mb-6 border border-white/20">
                    <svg class="w-4 h-4 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Free • Private • Secure</span>
                </div>

                <!-- Main Headline -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold tracking-tight mb-4 leading-tight">
                    Your Life,<br class="hidden sm:block"/>
                    <span class="bg-gradient-to-r from-yellow-200 via-yellow-300 to-yellow-200 bg-clip-text text-transparent">Your Story</span>
                </h1>

                <!-- Subheadline -->
                <p class="text-xl md:text-2xl text-blue-100 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Write freely. Reflect deeply. Your thoughts deserve a space that's completely yours—private, secure, and always accessible.
                </p>

                @guest
                    <!-- Centered Register Form (Optimized Spacing + No Inner Full-Screen) -->
                    <div class="max-w-md md:max-w-3xl mx-auto mb-10">
                        <div class="bg-white/95 dark:bg-gray-800/95 rounded-2xl shadow-xl border border-white/20 p-8 backdrop-blur-sm">

                            <!-- Header -->
                            <div class="text-center mb-6">
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Your Account</h2>
                                <p class="text-gray-600 dark:text-gray-400">Start journaling in less than 60 seconds</p>
                            </div>

                            <!-- FORM -->
                            <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold mb-1 text-left">Email Address</label>
                                        <div class="relative">
                                            <input id="email" type="email" name="email" required autocomplete="email"
                                                   placeholder="you@example.com" value="{{ old('email') }}"
                                                   class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute h-5 w-5 left-3 top-3 text-gray-400">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                <path d="M3 7l9 6l9 -6" />
                                            </svg>
                                        </div>
                                        @error('email')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-1 text-left">Username</label>
                                        <div class="relative">
                                            <input id="username" type="text" name="username" required
                                                   placeholder="johndoe" value="{{ old('username') }}"
                                                   class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute h-5 w-5 left-3 top-3 text-gray-400">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                                <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                                                <path d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                                            </svg>
                                        </div>
                                        @error('username')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-1 text-left">Password</label>
                                        <div class="relative">
                                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                                   placeholder="•••••••••" minlength="8"
                                                   class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute h-5 w-5 left-3 top-3 text-gray-400">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                            </svg>
                                        </div>
                                        @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold mb-1 text-left">Confirm Password</label>
                                        <div class="relative">
                                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                                   placeholder="•••••••••" autocomplete="new-password" minlength="8"
                                                   class="w-full pl-10 pr-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute h-5 w-5 left-3 top-3 text-gray-400">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                            </svg>
                                        </div>
                                    </div>

                                </div>

                                <button type="submit"
                                        class="w-full py-3.5 px-6 rounded-xl font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:scale-[1.02] shadow-lg transition">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        Get Started Free
                                    </span>
                                </button>
                            </form>

                            <p class="text-center text-sm text-gray-600 dark:text-gray-300 mt-6">
                                Already have an account? <a href="{{ route('login') }}" class="font-semibold underline">Sign in</a>
                            </p>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>


    <!-- Features Section -->
    <div class="bg-gray-50 dark:bg-gray-900 py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Everything you need to journal with confidence
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Built with your privacy and peace of mind as the top priority
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Feature 1 -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Bank-Level Security
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Every entry is encrypted with military-grade security. Your thoughts stay yours—no exceptions, no backdoors, no compromises.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Zero Friction Writing
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Start writing in seconds. No complicated setup, no unnecessary fields. Just your email and you're ready to capture life's moments.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        Write Anywhere, Anytime
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Inspiration doesn't wait for WiFi. Write offline and sync automatically when you're back online. Your journal follows you everywhere.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        App-Like Experience
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                        Add to your home screen for instant access. Lightning-fast, beautifully simple, and feels like a native app—because it practically is.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Proof / Benefits Section -->
    <div class="bg-white dark:bg-gray-800 py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Why people love journaling with Ediary
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 dark:text-blue-400 mb-2">100%</div>
                    <div class="text-lg font-medium text-gray-900 dark:text-white mb-2">Private</div>
                    <p class="text-gray-600 dark:text-gray-400">Your entries are encrypted and only you can read them</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 dark:text-blue-400 mb-2">0</div>
                    <div class="text-lg font-medium text-gray-900 dark:text-white mb-2">Personal Data</div>
                    <p class="text-gray-600 dark:text-gray-400">No name, birthday, or tracking. Just your email for login</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-blue-600 dark:text-blue-400 mb-2">∞</div>
                    <div class="text-lg font-medium text-gray-900 dark:text-white mb-2">Entries</div>
                    <p class="text-gray-600 dark:text-gray-400">Write unlimited entries. No storage limits, ever</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog Section -->
    <div class="bg-gray-50 dark:bg-gray-900 py-20 md:py-32 border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                        Insights & Inspiration
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400">Discover tips on journaling, productivity, and personal growth.</p>
                </div>
                <a href="/blog" class="hidden md:flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:underline">
                    View All Articles
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Article 1 -->
                <a href="{{route('blogs.goal-setting-for-success')}}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="p-8">
                        <div class="flex items-center gap-2 text-xs font-semibold text-blue-600 dark:text-blue-400 mb-4 uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            Goal Setting
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            5 Steps to Design the Life You've Always Dreamed Of
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                            Turn your goals into achievements with clear, actionable strategies that lead to real success.
                        </p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-500">
                            <span>By Shakil Alam</span>
                        </div>
                    </div>
                </a>

                <!-- Article 2 -->
                <a href="{{route('blogs.how-to-start-writing-a-diary')}}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="p-8">
                        <div class="flex items-center gap-2 text-xs font-semibold text-purple-600 dark:text-purple-400 mb-4 uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            Getting Started
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            How to Start Writing a Diary
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                            All you need is a willingness to write. Start by figuring out what you want to journal about and let the words flow.
                        </p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-500">
                            <span>By Shakil Alam</span>
                        </div>
                    </div>
                </a>

                <!-- Article 3 -->
                <a href="{{route('blogs.these-8-good-things')}}" class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 md:col-span-2 lg:col-span-1">
                    <div class="p-8">
                        <div class="flex items-center gap-2 text-xs font-semibold text-green-600 dark:text-green-400 mb-4 uppercase tracking-wide">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            Benefits
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            8 Good Things That Happen When You Start Journaling
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                            Discover how writing to yourself unlocks creativity, healing, and self-awareness in ways you never imagined.
                        </p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-500">
                            <span>By Internet Blogger</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="mt-16 text-center md:hidden">
                <a href="/blog" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-bold hover:underline">
                    View All Articles
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 text-white py-20 md:py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-6">
                Start your journey today
            </h2>
            <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                Join thousands who've made journaling a daily habit. Your future self will thank you.
            </p>
            @guest
                <register-form></register-form>
            @endguest

            <p class="text-sm text-blue-200 mt-8">
                Free forever. No credit card required. Cancel anytime.
            </p>
        </div>
    </div>

@endsection
