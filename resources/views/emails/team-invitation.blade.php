@component('mail::message')
{{ __('teams.team_invitation.invitation_message', ['team' => $invitation->team->name]) }}

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
{{ __('teams.team_invitation.no_account') }}

@component('mail::button', ['url' => route('register')])
{{ __('teams.team_invitation.create_account') }}
@endcomponent

{{ __('teams.team_invitation.existing_account') }}

@else
{{ __('teams.team_invitation.accept_prompt') }}
@endif


@component('mail::button', ['url' => $acceptUrl])
{{ __('teams.team_invitation.accept_invitation') }}
@endcomponent

{{ __('teams.team_invitation.discard') }}
@endcomponent
