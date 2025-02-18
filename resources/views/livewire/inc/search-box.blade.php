<div>
    <label for="table-search" class="sr-only">{{ __('common.actions.search') }}</label>
    <div class="relative">
        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <x-heroicon-o-magnifying-glass class="size-4 text-gray-500 dark:text-gray-400" />
        </div>
        <input type="text"
               wire:model.live.debounce.500ms="search"
               placeholder="{{ __('common.search_for_items') }}"
               id="table-search"
               class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-64 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-300 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>
</div>
