@props(['href' => '#'])

<li>
    <div class="flex items-center">
        <svg class="rtl:rotate-180 w-2 h-2 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
        </svg>
        <a href="{{ $href }}" wire:navigate class="ms-2 md:ms-3 text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-all ease-in-out duration-500">
            {{ $slot }}
        </a>
    </div>
</li>
