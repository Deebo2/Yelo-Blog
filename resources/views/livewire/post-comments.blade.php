<div class="pt-10 mt-10 border-t border-gray-100 comments-box">
    <h2 class="mb-5 text-2xl font-semibold text-gray-900">Discussions</h2>
    @auth
    <textarea
        wire:model="comment"
        class="w-full p-4 text-sm text-gray-700 border-gray-200 rounded-lg bg-gray-50 focus:outline-none placeholder:text-gray-400"
        cols="30" rows="7"></textarea>
        <x-button
            wire:click="postComment"
        >Post Comment</x-button>
    @else
     <a wire:navigate class="py-1 text-yellow-500 underline" href="{{route('login')}}"> Login to Post Comments</a>
    @endauth
    <div class="px-3 py-2 mt-5 user-comments">
        @forelse ($this->comments as $comment)
        <div class="comment [&:not(:last-child)]:border-b border-gray-100 py-5">
            <div class="flex items-center mb-4 text-sm user-meta">
                <x-posts.author :author="$comment->user" size="sm" />
                <span class="text-gray-500">{{$comment->created_at->diffForHumans()}}</span>
            </div>

            <div class="text-sm text-justify text-gray-700">
                {{$comment->comment_body}}
            </div>
        </div>
        @empty
         <div class="text-center text-gray-500">
            <span> No Comments Posted</span>
         </div>
        @endforelse
    </div>
    <div class="my-2">
        {{ $this->comments->links() }}
    </div>
</div>
