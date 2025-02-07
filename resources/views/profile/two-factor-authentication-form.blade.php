<x-action-section>
    <x-slot name="title">
        {{ __('profile.two_factor_authentication_form.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile.two_factor_authentication_form.description') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('profile.two_factor_authentication_form.messages.finish_enabling') }}
                @else
                    {{ __('profile.two_factor_authentication_form.messages.enabled') }}
                @endif
            @else
                {{ __('profile.two_factor_authentication_form.messages.not_enabled') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>
                {{ __('profile.two_factor_authentication_form.messages.description') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    <p class="font-semibold">
                        @if ($showingConfirmation)
                            {{ __('profile.two_factor_authentication_form.messages.finish_qr') }}
                        @else
                            {{ __('profile.two_factor_authentication_form.messages.qr_code') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 p-2 inline-block bg-white">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    <p class="font-semibold">
                        {{ __('profile.two_factor_authentication_form.fields.setup_key') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('profile.two_factor_authentication_form.fields.code') }}" />

                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code"
                            wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-input-error for="code" class="mt-2" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    <p class="font-semibold">
                        {{ __('profile.two_factor_authentication_form.messages.recovery_codes_info') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        {{ __('common.actions.enable') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('profile.two_factor_authentication_form.actions.regenerate_recovery_codes') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="me-3" wire:loading.attr="disabled">
                            {{ __('common.actions.confirm') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-secondary-button class="me-3">
                            {{ __('profile.two_factor_authentication_form.actions.show_recovery_codes') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-secondary-button wire:loading.attr="disabled">
                            {{ __('common.actions.cancel') }}
                        </x-secondary-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            {{ __('common.actions.disable') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-action-section>
