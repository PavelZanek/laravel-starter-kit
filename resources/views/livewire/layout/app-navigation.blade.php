<div x-data="{ open: false }"
     x-init="() => {
        $watch('open', value => {
            document.body.classList.toggle('overflow-hidden', value);
        });
    }">
    <!-- Sidebar Mobile Toggle -->
    <div class="sticky z-20 bg-white border-y px-4 md:px-8 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex gap-2 items-center py-1 px-2">
            <button type="button" @click="open = true" class="lg:hidden text-gray-500 hover:text-gray-600 focus:outline-none">
                <span class="sr-only">Open sidebar</span>
                <x-heroicon-o-bars-3 class="flex-shrink-0 size-6" />
            </button>
            <a wire:navigate href="{{ route('dashboard') }}" class="lg:hidden mr-2 flex items-center gap-2 text-sm font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <x-application-mark class="block h-4 w-auto" style="min-width: 30px;" />
            </a>

            <!-- Topbar -->
            <div class="pl-0 lg:pl-64 flex items-center justify-between gap-x-2 w-full">
                <div>
                    <div></div>
                </div>
                <div class="flex items-center justify-end gap-x-2">

                    <!-- Dark Mode Switcher -->
                    @persist('topbarMenu')
                    <div class="flex items-center">
                        <div class="relative">
                            <button id="dark-mode-toggle" type="button" class="inline-flex items-center px-1 md:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 no-color-transition smooth-color-transition">
                                <x-heroicon-o-moon class="size-5 md:size-6 block dark:hidden" />
                                <x-heroicon-o-sun class="size-5 md:size-6 hidden dark:block" />
                            </button>
                        </div>

                        <!-- Language Switcher -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-1 md:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 no-color-transition smooth-color-transition">
                                            <x-heroicon-o-language class="size-5 md:size-6" />
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    <!-- Language Select -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('nav.language_switcher.choose_language') }}
                                    </div>

                                    @foreach(config('project.available_locales') as $availableLocaleKey)
                                        <x-switchable-locale :locale="$availableLocaleKey" />
                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Teams Dropdown -->
                        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && auth()->check())
                            <div class="relative">
                                <x-dropdown align="right" width="60">
                                    <x-slot name="trigger">
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-1 md:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 no-color-transition smooth-color-transition">
                                                <x-heroicon-o-users class="size-5 md:size-6" />
                                            </button>
                                        </span>
                                    </x-slot>

                                    <x-slot name="content">
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                <span class="font-bold">{{ Auth::user()->currentTeam->name }}</span><br />
                                                {{ __('nav.teams.manage_team') }}
                                            </div>

                                            <!-- Team Settings -->
                                            <x-dropdown-link wire:navigate href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                {{ __('nav.teams.team_settings') }}
                                            </x-dropdown-link>

                                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                <x-dropdown-link wire:navigate href="{{ route('teams.create') }}">
                                                    {{ __('nav.teams.create_new_team') }}
                                                </x-dropdown-link>
                                            @endcan

                                            <!-- Team Switcher -->
                                            @if (Auth::user()->allTeams()->count() > 1)
                                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    {{ __('nav.teams.switch_teams') }}
                                                </div>

                                                @foreach (Auth::user()->allTeams() as $team)
                                                    <x-switchable-team :team="$team" />
                                                @endforeach
                                            @endif
                                        </div>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif

                        <!-- User Settings -->
                        <div class="relative">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-1 md:px-2 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 no-color-transition smooth-color-transition">
                                            <x-heroicon-o-user class="size-5 md:size-6" />
                                        </button>
                                    </span>
                                </x-slot>

                                <x-slot name="content">
                                    @auth
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            <span class="font-bold">{{ Auth::user()->name }}</span><br />
                                            {{ __('nav.account.manage_account') }}
                                        </div>

                                        <x-dropdown-link wire:navigate href="{{ route('profile.show') }}">
                                            {{ __('nav.account.profile') }}
                                        </x-dropdown-link>

                                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                            <x-dropdown-link wire:navigate href="{{ route('api-tokens.index') }}">
                                                {{ __('nav.account.api_tokens') }}
                                            </x-dropdown-link>
                                        @endif

                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}" x-data>
                                            @csrf

                                            <x-dropdown-link href="{{ route('logout') }}"
                                                             @click.prevent="$root.submit();">
                                                {{ __('nav.account.logout') }}
                                            </x-dropdown-link>
                                        </form>
                                    @else
                                        <x-dropdown-link wire:navigate href="{{ route('login') }}">
                                            {{ __('nav.login') }}
                                        </x-dropdown-link>

                                        @if (Route::has('register'))
                                            <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                            <x-dropdown-link wire:navigate href="{{ route('register') }}">
                                                {{ __('nav.register') }}
                                            </x-dropdown-link>
                                        @endif
                                    @endauth
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>
                    @endpersist

                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div :class="{ 'translate-x-0': open }" class="h-screen flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300 fixed top-0 start-0 bottom-0 z-[49] w-64 bg-white border-e border-gray-200 pt-7 pb-10 lg:block dark:bg-gray-800 dark:border-gray-700">
        <div class="px-6 mb-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a wire:navigate href="{{ route('dashboard') }}" class="flex items-center gap-2 text-sm font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <x-application-mark class="block h-7 w-auto" style="min-width: 30px;" />
                    <span class="text-nowrap">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>
            <div>
                <button type="button" @click="open = false" class="lg:hidden text-gray-500 hover:text-gray-600 focus:outline-none">
                    <span class="sr-only">{{ __('nav.close_sidebar') }}</span>
                    <x-heroicon-o-x-mark class="size-6" />
                </button>
            </div>
        </div>

        <!-- Sidebar Content -->
        <div class="flex flex-col flex-1 h-full">
            <div class="flex flex-col h-full">
                <nav class="px-6 flex flex-col flex-grow overflow-y-auto min-h-16">
                    <ul>
                        @auth
                            <x-sidebar-nav-link wire:navigate :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="heroicon-o-home">
                                {{ __('nav.dashboard') }}
                            </x-sidebar-nav-link>
                        @endauth
                    </ul>
                </nav>

                <div class="px-6 pb-4 md:pb-8 overflow-y-auto min-h-16">
                    <ul>
                        <x-sidebar-nav-link href="https://github.com/PavelZanek/laravel-starter-kit" target="_blank" icon="heroicon-o-code-bracket">
                            {{ __('nav.github_repository') }}
                        </x-sidebar-nav-link>
                        <x-sidebar-nav-group label="{{ __('nav.useful_links.useful_links') }}" icon="heroicon-o-link">
                            <x-sidebar-nav-link href="https://www.pavelzanek.com/" target="_blank" icon="heroicon-o-user">
                                {{ __('nav.useful_links.about_author') }}
                            </x-sidebar-nav-link>

                            <x-sidebar-nav-group label="{{ __('nav.useful_links.social_media') }}" icon="heroicon-o-user-group" class="my-2">
                                <x-sidebar-nav-link href="https://github.com/PavelZanek" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.github') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://x.com/PavelZanek" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.twitter') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://www.linkedin.com/in/pavelzanek/" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.linkedin') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://pinkary.com/@zanekpavel" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.pinkary') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://mastodon.social/@zanek" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.mastodon') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://bsky.app/profile/zanekpavel.bsky.social" target="_blank" icon="heroicon-o-user-plus">
                                    {{ __('nav.useful_links.bluesky') }}
                                </x-sidebar-nav-link>
                            </x-sidebar-nav-group>

                            <x-sidebar-nav-group label="{{ __('nav.useful_links.live_streams') }}" icon="heroicon-o-microphone" class="my-2">
                                <x-sidebar-nav-link href="https://www.twitch.tv/pavelzanek" target="_blank" icon="heroicon-o-video-camera">
                                    {{ __('nav.useful_links.twitch') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://www.youtube.com/@PavelZanek" target="_blank" icon="heroicon-o-video-camera">
                                    {{ __('nav.useful_links.youtube') }}
                                </x-sidebar-nav-link>
                            </x-sidebar-nav-group>

                            <x-sidebar-nav-group label="{{ __('nav.useful_links.donate') }}" icon="heroicon-o-currency-dollar" class="my-2">
                                <x-sidebar-nav-link href="https://github.com/sponsors/pavelzanek" target="_blank" icon="heroicon-o-currency-dollar">
                                    {{ __('nav.useful_links.github') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://streamelements.com/pavelzanek/tip" target="_blank" icon="heroicon-o-currency-dollar">
                                    {{ __('nav.useful_links.stream_elements') }}
                                </x-sidebar-nav-link>
                                <x-sidebar-nav-link href="https://www.paypal.com/paypalme/pavelzanek" target="_blank" icon="heroicon-o-currency-dollar">
                                    {{ __('nav.useful_links.paypal') }}
                                </x-sidebar-nav-link>
                            </x-sidebar-nav-group>
                        </x-sidebar-nav-group>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Backdrop -->
    <div x-show="open" x-cloak x-transition.opacity @click="open = false" class="fixed inset-0 z-[48] bg-gray-900 bg-opacity-50 dark:bg-opacity-80">

    </div>
</div>
