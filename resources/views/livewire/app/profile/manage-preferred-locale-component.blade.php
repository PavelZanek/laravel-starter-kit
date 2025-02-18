<x-form-section submit="saveItem">
    <x-slot name="title">
        {{ __('profile.preferred_locale_form.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile.preferred_locale_form.description') }}
    </x-slot>

    <x-slot name="form">
        <!-- Preferred Locale -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="preferred_locale" :value="__('profile.preferred_locale_form.fields.preferred_locale')" />
            <x-select id="preferred_locale" wire:model="form.modelData.preferred_locale">
                @foreach($preferredLocales as $locale)
                    <option value="{{ $locale['value'] }}">{{ $locale['name'] }}</option>
                @endforeach
            </x-select>
            <x-input-error for="form.modelData.preferred_locale" class="mt-2" />
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
