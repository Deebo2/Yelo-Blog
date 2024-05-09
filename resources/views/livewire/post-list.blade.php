<div class="px-3 py-6 lg:px-7">
    <div class="flex items-center justify-between border-b border-gray-100">
        <div class="text-gray-700">
            @if($this->activeCategory || $search)
                <button wire:click="clearFilters()" class="mr-3 text-xs text-gray-500">X</button>
            @endif
            @if($category = $this->activeCategory)
            <x-posts.category-badge :category="$category"  />
            @endif
            @if($search)
                <span class="ml-3">{{__('blog.containing')}} : <strong class="text-yellow-500 ">{{$search}}</strong></span>
            @endif
        </div>
        <div  class="flex items-center space-x-4 font-light ">
            <x-label>{{__('blog.popular')}}</x-label>
            <x-checkbox wire:model.live="popular"/>
            <button @class(['py-4',
             'text-gray-500' => ($sort !== 'desc'),
             'text-gray-900 border-b border-gray-700' => ($sort === 'desc')
             ])  wire:click="setSort('desc')">{{__('blog.latest')}}</button>
            <button @class(['py-4',
            'text-gray-500' => ($sort !== 'asc'),
            'text-gray-900 border-b border-gray-700' => ($sort === 'asc')
            ]) wire:click="setSort('asc')">{{__('blog.oldest')}}</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $post)
        <x-posts.post-item wire:key="{{$post->id}}" :post="$post"/>
        @endforeach

    </div>
    <div class="my-3">
        {{$this->posts->onEachSide(1)->links()}}
    </div>
</div>
