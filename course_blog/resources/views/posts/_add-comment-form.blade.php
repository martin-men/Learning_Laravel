<x-panel>
    @auth
        <form action="/posts/{{ $post->slug }}/comments" method="post">
            @csrf

            <header class="flex items-center">
                <img src="https://i.pravatar.cc/60?u={{ auth()->user()->id }}"
                     alt="Current user profile avatar" width="40" height="40"
                     class="rounded-full"/>
                <h2 class="ml-4">Want to participate?</h2>
            </header>
            <div class="mt-6">
                                    <textarea name="body" class="w-full text-sm rounded-xs"
                                              placeholder="Quick, think of something to say!" rows="5"
                                              required></textarea>
                @error('body')
                    <span class="text-xs text-red">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex justify-end mt-6 border-t border-gray-200 pt-6">
                <x-form.button>Post</x-form.button>
            </div>
        </form>
    @else
        <p class="text-semibold">
            <a href="/register" class="hover:underline">Register</a> or
            <a href="/login" class="hover:underline">Log in</a> to leave a comment.
        </p>
    @endauth
</x-panel>
