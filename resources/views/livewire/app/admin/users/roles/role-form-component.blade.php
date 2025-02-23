<div>

    <x-form-section submit="saveRecord">
        <x-slot name="title">
            {{ __('roles.form_sections.role_details.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('roles.form_sections.role_details.description') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('roles.form.name') }}" />
                @if(isset($role) && $role->is_default)
                    <x-input id="name" type="text" class="mt-1 block w-full disabled cursor-not-allowed" wire:model="form.modelData.name" disabled readonly/>
                @else
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="form.modelData.name"/>
                @endif
                <x-input-error for="form.modelData.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="guard-name" value="{{ __('roles.form.guard_name') }}" />
                @if(isset($role) && $role->is_default)
                    <x-input id="guard-name" type="text" class="mt-1 block w-full disabled cursor-not-allowed" wire:model="form.modelData.guard_name" disabled readonly/>
                @else
                    <x-select id="guard-name" class="mt-1 block w-full" wire:model="form.modelData.guard_name" required>
                        <option value="">{{ __('common.select') }}</option>
                        @foreach($roleGuards as $roleGuard)
                            <option value="{{ $roleGuard['value'] }}">{{ $roleGuard['name'] }}</option>
                        @endforeach
                    </x-select>
                @endif
                <x-input-error for="form.modelData.guard_name" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('common.flash_messages.saved') }}
            </x-action-message>

            @if(!isset($role) || (isset($role) && !$role->is_default))
                <x-button wire:loading.attr="disabled">
                    {{ __('common.actions.save') }}
                </x-button>
            @endif
        </x-slot>
    </x-form-section>

    <x-form-section submit="saveRecord" class="mt-4 md:mt-8">
        <x-slot name="title">
            {{ __('roles.form_sections.permissions.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('roles.form_sections.permissions.description') }}
        </x-slot>

        <x-slot name="form">

            <div class="col-span-6 sm:col-span-4">
                <x-label value="{{ __('roles.form.permissions') }}" />

                <div class="mt-2">
                    @foreach($permissions as $permissionGroup => $permissionData)

                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('common.group') }}: {{ $permissionGroup }}
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mt-2">
                            @foreach($permissionData as $permission)
                                <div>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input wire:model="form.relations.permissions.{{ $permission['id'] }}" type="checkbox" value="{{ $permission['id'] }}" class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ \Illuminate\Support\Str::afterLast($permission['name'], '.') }}
                                        </span>
                                    </label>
                                    <x-input-error for="form.relations.permissions.*" class="mt-2" />
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>

            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('common.flash_messages.saved') }}
            </x-action-message>

            @if(!isset($role) || (isset($role) && !$role->is_default))
                <x-button wire:loading.attr="disabled">
                    {{ __('common.actions.save') }}
                </x-button>
            @endif
        </x-slot>
    </x-form-section>

    @if(isset($role) && !$role->is_default)
        <x-form-section submit="confirmItemDeletion" class="mt-4 md:mt-8">
            <x-slot name="title">
                {{ __('roles.form_sections.role_details.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('roles.form_sections.role_details.description') }}
            </x-slot>

            <x-slot name="form">
                <div class="col-span-6 sm:col-span-4">
                    <p class="text-gray-500 dark:text-gray-400">
                        {{ __('roles.form_sections.delete.more_info') }}
                    </p>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-danger-button wire:click="confirmItemDeletion" wire:loading.attr="disabled">
                    {{ __('common.actions.delete') }}
                </x-danger-button>
            </x-slot>
        </x-form-section>

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
    @endif
</div>
