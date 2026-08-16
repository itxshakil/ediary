@extends('layouts.app')
@section('title', $entry->title ?? 'Shared entry')
@section('content')
    <div class="container mx-auto max-w-3xl px-4 py-8">
        <x-diary-card :entry="$entry" :show-owner="true" />

        <div class="mt-4 flex items-center gap-4">
            @auth
                <button
                    id="like-btn"
                    data-diary-id="{{ $entry->id }}"
                    data-liked="{{ $entry->likes->contains('user_id', auth()->id()) ? '1' : '0' }}"
                    class="inline-flex items-center gap-1.5 rounded-full border border-gray-200 px-4 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800"
                >
                    <span id="like-icon">{{ $entry->likes->contains('user_id', auth()->id()) ? '❤️' : '🤍' }}</span>
                    <span id="like-count">{{ $entry->likes_count }}</span>
                </button>
            @else
                <span class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-700 dark:text-gray-200">
                    <span>🤍</span>
                    <span>{{ $entry->likes_count }}</span>
                </span>
            @endauth
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $entry->views_count }} views</span>
            <button
                id="share-entry-btn"
                class="ml-auto inline-flex items-center gap-1.5 rounded-full border border-gray-200 px-4 py-1.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800"
            >
                Share
            </button>
        </div>

        <div class="mt-8">
            <h2 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                Comments ({{ $entry->comments_count }})
            </h2>

            @if (session('success'))
                <p class="mb-4 text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
            @endif

            @auth
                @if ($entry->allow_comments)
                    <form method="POST" action="{{ route('diary.comment', $entry) }}" class="mb-6">
                        @csrf
                        <textarea
                            name="comment"
                            rows="3"
                            required
                            maxlength="2000"
                            placeholder="Write a comment..."
                            class="w-full rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-900 focus:border-transparent focus:ring-2 focus:ring-blue-500/50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100"
                        >{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="mt-1 text-xs text-red-500 italic">{{ $message }}</p>
                        @enderror
                        <button
                            type="submit"
                            class="mt-2 inline-flex items-center rounded-full bg-blue-600 px-4 py-1.5 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700"
                        >
                            Post comment
                        </button>
                    </form>
                @else
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">Comments are disabled for this entry.</p>
                @endif
            @else
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline dark:text-blue-400">Log in</a>
                    to comment.
                </p>
            @endauth

            <div class="space-y-4">
                @forelse ($entry->comments as $comment)
                    <div class="flex gap-3">
                        <img
                            src="{{ $comment->user->profile->image }}"
                            alt="{{ $comment->user->username }}"
                            class="h-8 w-8 shrink-0 rounded-full object-cover"
                        />
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $comment->user->profile->name ?? $comment->user->username }}</span>
                                <time class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</time>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    @auth
        <script>
            document.getElementById('like-btn')?.addEventListener('click', async (event) => {
                const button = event.currentTarget;
                const icon = document.getElementById('like-icon');
                const count = document.getElementById('like-count');

                try {
                    const response = await axios.post(`/diary/${button.dataset.diaryId}/like`);
                    button.dataset.liked = response.data.liked ? '1' : '0';
                    icon.textContent = response.data.liked ? '❤️' : '🤍';
                    count.textContent = response.data.likes_count;
                } catch {
                    // Silently ignore — the button state simply won't update.
                }
            });
        </script>
    @endauth

    <script>
        document.getElementById('share-entry-btn')?.addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Ediary — Shared entry',
                        url: window.location.href,
                    });

                    return;
                } catch {
                    // Fall through to clipboard fallback when share is cancelled or unsupported.
                }
            }

            await navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        });
    </script>
@endsection
