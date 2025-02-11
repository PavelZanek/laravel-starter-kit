<footer class="sm:flex sm:items-center sm:justify-between gap-x-4 p-4 antialiased bg-white dark:bg-gray-800 mt-auto">
    <div>
        <p class="mb-4 text-sm text-center sm:text-left text-gray-500 dark:text-gray-400 sm:mb-0">
            &copy; {{ now()->format('Y') }} <a wire:navigate href="{{ route('dashboard') }}" class="hover:underline">{{ config('app.name') }}</a>. All rights reserved.
        </p>
        <p class="mb-4 text-sm text-center sm:text-left text-gray-500 dark:text-gray-400 sm:mb-0">
            {{ 'Laravel v' . app()->version() . ', PHP ' . phpversion() . '.' }}
        </p>
    </div>
    <div class="flex justify-center items-center space-x-1">
        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ __('nav.created_by') }} <a href="https://www.pavelzanek.com/en" target="_blank" class="font-medium text-indigo-700 dark:text-indigo-300">Pavel Zaněk</a>.</p>
    </div>
</footer>
