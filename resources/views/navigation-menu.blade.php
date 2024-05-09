<nav class="flex items-center justify-between px-6 py-3 border-b border-gray-100">
    <div id="nav-left" class="flex items-center">
        <x-application-mark class="block w-auto h-9" />
        <div class="ml-10 top-menu">
            <div class="flex space-x-4">
                <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('menu.home') }}
                </x-nav-link>
                <x-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                    {{ __('menu.blog') }}
                </x-nav-link>

            </div>
        </div>
    </div>
    <div id="nav-right" class="flex items-center md:space-x-6">
        @auth
        <x-partials.header-right-auth />
        @else
         <x-partials.header-right-guest />
        @endauth
    </div>
</nav>
