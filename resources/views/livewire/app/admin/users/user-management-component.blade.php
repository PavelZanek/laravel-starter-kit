<div id="user-management-component">

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <div class="px-2 md:px-0 pb-4">
            <div class="flex flex-col md:flex-row gap-2 items-center">
                <div class="w-full md:w-auto">
                    @include('livewire.inc.search-box')
                </div>

                <div class="w-full flex gap-2 items-center">
                    <div class="w-full md:w-auto">
                        <x-select wire:model.live.debounce.500ms="selectedRole" class="w-full mt-0 md:min-w-36">
                            <option value="not_set">{{ __('users.index.table.select_role') }}</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="w-full md:w-auto ml-auto">
                        <x-button wire:click="confirmItemAdd()" wire:loading.attr="disabled" class="w-full">
                            {{ __('common.actions.add') }}
                        </x-button>
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
                        'thValue' => __('users.index.table.name'),
                        'thAttribute' => 'name',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('users.index.table.email'),
                        'thAttribute' => 'email',
                    ])
                    @include('livewire.inc.sorting-th', [
                        'thValue' => __('common.created_at'),
                        'thAttribute' => 'created_at',
                    ])
                    <th scope="col" class="px-6 py-3">
                        {{ __('users.index.table.role') }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">
                            {{ __('common.table_actions') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600 {{ !$loop->last ? 'border-b dark:border-gray-700 border-gray-200' : '' }}">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $user->id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                @if($role->name === \App\Enums\Users\DefaultRoleEnum::SUPER_ADMIN->value)
                                    <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">
                                        {{ \App\Enums\Users\DefaultRoleEnum::SUPER_ADMIN->details()['name'] }}
                                    </span>
                                @elseif($role->name === \App\Enums\Users\DefaultRoleEnum::ADMIN->value)
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300">
                                        {{ \App\Enums\Users\DefaultRoleEnum::ADMIN->details()['name'] }}
                                    </span>
                                @elseif($role->name === \App\Enums\Users\DefaultRoleEnum::BASIC->value)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                                        {{ \App\Enums\Users\DefaultRoleEnum::BASIC->details()['name'] }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">
                                        {{ $role->name }}
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at->format(__('common.formats.date')) }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <x-secondary-button wire:click="confirmItemEdit({{ $user->id }})" wire:loading.attr="disabled" class="mr-2">
                                {{ __('common.actions.edit') }}
                            </x-secondary-button>
                            <x-danger-button wire:click="confirmItemDeletion({{ $user->id }})" wire:loading.attr="disabled">
                                {{ __('common.actions.remove') }}
                            </x-danger-button>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4" colspan="6">
                            <div class="flex justify-center items-center">
                                <span class="text-gray-400 dark:text-gray-600">
                                    {{ __('users.index.table.no_items') }}
                                </span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(count($users) > $itemsPerPage)
        <div class="mt-2 md:mt-4 xl:mt-8 px-4 py-4 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg">
            {{ $users->links(data: ['scrollTo' => '#user-management-component']) }}
        </div>
    @endif

    <x-dialog-modal wire:model.live="confirmingItemManage">
        <x-slot name="title">
            {{ isset($this->form->modelData['id']) ? __('users.index.edit_user') : __('users.index.create_user') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <x-label for="name" value="{{ __('users.index.form.name') }}" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="form.modelData.name" required />
                    <x-input-error for="form.modelData.name" class="mt-2" />
                </div>

                <div>
                    <x-label for="email" value="{{ __('users.index.form.email') }}" />
                    <x-input id="email" type="email" class="mt-1 block w-full" wire:model="form.modelData.email" required />
                    <x-input-error for="form.modelData.email" class="mt-2" />
                </div>

                <div>
                    <x-label for="role" value="{{ __('users.index.form.role') }}" />
                    <x-select id="role" class="mt-1 block w-full" wire:model="form.relations.role" required>
                        <option value="">{{ __('common.select') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error for="form.relations.role" class="mt-2" />
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingItemManage')" wire:loading.attr="disabled">
                {{ __('common.actions.cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="saveRecord" wire:loading.attr="disabled">
                {{ __('common.actions.save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('users.index.delete_user') }}
        </x-slot>

        <x-slot name="content">
            {{ __('users.index.confirm_delete_user') }}
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
