@hasSection('breadcrumb')
    <nav class="flex ms-4 md:ms-8 mt-2 md:mt-6 overflow-x-auto whitespace-nowrap pb-2" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a wire:navigate href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all ease-in-out duration-500">
                    <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                </a>
            </li>
            @yield('breadcrumb')
        </ol>
    </nav>
@endif
{{--        Example--}}
{{--        @section('breadcrumb')--}}
{{--            <x-breadcrumb-item wire:navigate href="{{ route('employees.index') }}">--}}
{{--                {{ __('app/employee-translations.index.headline') }}--}}
{{--            </x-breadcrumb-item>--}}
{{--            <x-breadcrumb-current-item>--}}
{{--                {{ __('app/employee-translations.edit.headline') }}--}}
{{--            </x-breadcrumb-current-item>--}}
{{--        @endsection--}}
