<x-form-section submit="saveItem">
    <x-slot name="title">
        {{ __('profile.notification_channels_form.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile.notification_channels_form.description') }}
    </x-slot>

    <x-slot name="form">
        <!-- Database -->
        <div class="col-span-6 sm:col-span-4">
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" value="" class="sr-only peer" checked disabled>
                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-400 dark:text-gray-500">
                    {{ __('profile.notification_channels_form.fields.database') }}
                </span>
            </label>
        </div>

        <!-- Mail -->
        <div class="col-span-6 sm:col-span-4">
            <label for="mail_notification_channel" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.modelData.mail" id="mail_notification_channel" type="checkbox" value="" class="sr-only peer">
                <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    {{ __('profile.notification_channels_form.fields.mail') }}
                </span>
            </label>
            <x-input-error for="form.modelData.mail" class="mt-2" />
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
