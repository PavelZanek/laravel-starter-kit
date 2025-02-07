<x-action-section>
    <x-slot name="title">
        {{ __('teams.delete_team_form.title') }}
    </x-slot>

    <x-slot name="description">
        {{ __('teams.delete_team_form.description') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('teams.delete_team_form.warning') }}
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ __('teams.delete_team_form.action') }}
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                {{ __('teams.delete_team_form.title') }}
            </x-slot>

            <x-slot name="content">
                {{ __('teams.delete_team_form.confirmation') }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ __('common.actions.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ __('teams.delete_team_form.action') }}
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>
