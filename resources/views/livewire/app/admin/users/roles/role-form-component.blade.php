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
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model="form.modelData.name" required />
                <x-input-error for="form.modelData.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="guard-name" value="{{ __('roles.form.guard_name') }}" />
                <x-select id="guard-name" class="mt-1 block w-full" wire:model="form.modelData.guard_name" required>
                    <option value="">{{ __('common.select') }}</option>
                    @foreach($roleGuards as $roleGuard)
                        <option value="{{ $roleGuard['value'] }}">{{ $roleGuard['name'] }}</option>
                    @endforeach
                </x-select>
                <x-input-error for="form.modelData.guard_name" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('common.flash_messages.saved') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled">
                {{ __('common.actions.save') }}
            </x-button>
        </x-slot>
    </x-form-section>

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

    @if(isset($role))
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
