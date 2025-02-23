<div id="role-management-component">

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <div class="px-2 md:px-0 pb-4">
            <div class="flex flex-col md:flex-row gap-2 items-center">
                <div class="w-full md:w-auto">
                    @include('livewire.inc.search-box')
                </div>

                <div class="w-full flex gap-2 items-center">
                    <div class="w-full md:w-auto ml-auto">
                        <x-button-link weire:navigate href="{{ route('admin.roles.create') }}" class="w-full">
                            {{ __('common.actions.add') }}
                        </x-button-link>
                    </div>
                </div>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    @include('livewire.inc.sorting-th', [
                        'thValue' => 'ID',
                        'thAttribute' => 'id',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('roles.index.table.name'),
                        'thAttribute' => 'name',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('roles.index.table.guard_name'),
                        'thAttribute' => 'guard_name',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('roles.index.table.is_default'),
                        'thAttribute' => 'is_default',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('common.created_at'),
                        'thAttribute' => 'created_at',
                    ])
                    <th scope="col" class="px-6 py-3">
                        {{ __('roles.index.table.number_of_users') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">
                            {{ __('common.table_actions') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 {{ !$loop->last ? 'border-b dark:border-gray-700 border-gray-200' : '' }}">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $role->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $role->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $role->guard_name }}
                        </td>
                        <td class="px-6 py-4">
                            @if($role->is_default)
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                                    {{ $role->is_default ? __('common.yes') : __('common.no') }}
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">
                                    {{ $role->is_default ? __('common.yes') : __('common.no') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            {{ $role->created_at->format(__('common.formats.date')) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $role->users_count }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if(!$role->is_default)
                                <x-secondary-button-link wire:navigate href="{{ route('admin.roles.edit', $role) }}" class="mr-2">
                                    {{ __('common.actions.edit') }}
                                </x-secondary-button-link>
                                <x-danger-button wire:click="confirmItemDeletion({{ $role->id }})" wire:loading.attr="disabled">
                                    {{ __('common.actions.remove') }}
                                </x-danger-button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4" colspan="7">
                            <div class="flex justify-center items-center">
                                <span class="text-gray-400 dark:text-gray-600">
                                    {{ __('roles.index.table.no_items') }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(count($roles) > $itemsPerPage)
        <div class="mt-2 md:mt-4 xl:mt-8 px-4 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            {{ $roles->links(data: ['scrollTo' => '#role-management-component']) }}
        </div>
    @endif

    <x-confirmation-modal wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('roles.delete.delete_role') }}
        </x-slot>

        <x-slot name="content">
            {{ __('roles.delete.confirm_delete_role') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingItemDeletion')" wire:loading.attr="disabled">
                {{ __('common.actions.cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteRecord({{$confirmingItemDeletion}})" wire:loading.attr="disabled">
                {{ __('common.actions.delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
