<th scope="col" class="px-6 py-3">
    <div class="flex justify-start items-center gap-x-1">
        <div class="flex flex-col">
            @if($sortField === $thAttribute)
                @if($sortDirection === 'asc')
                    <button wire:click="sortBy('{{ $thAttribute }}', 'desc')" class="text-gray-400 hover:text-gray-800 dark:text-gray-600 dark:hover:text-gray-400">
                        <x-heroicon-o-chevron-up class="w-4 h-4" />
                    </button>
                @else
                    <button wire:click="sortBy('{{ $thAttribute }}', 'asc')" class="text-gray-400 hover:text-gray-800 dark:text-gray-600 dark:hover:text-gray-400">
                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                    </button>
                @endif
            @else
                <button wire:click="sortBy('{{ $thAttribute }}', 'asc')" class="text-gray-400 hover:text-gray-800 dark:text-gray-600 dark:hover:text-gray-400">
                    <x-heroicon-o-chevron-up class="w-4 h-4" />
                </button>
                <button wire:click="sortBy('{{ $thAttribute }}', 'desc')" class="-mt-1 text-gray-400 hover:text-gray-800 dark:text-gray-600 dark:hover:text-gray-400">
                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                </button>
            @endif
        </div>
        <div>
            {{ $thValue }}
        </div>
    </div>
</th>
