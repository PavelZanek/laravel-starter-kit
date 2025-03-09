<?php

declare(strict_types=1);

use App\Livewire\App\Profile\ManageNotificationChannelsComponent;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('initializes the form with the current user mail notification channel', function (): void {
    actingAs(User::factory()->create([
        'notification_channels' => ['mail' => true],
    ]));

    livewire(ManageNotificationChannelsComponent::class)
        ->assertSet('form.modelData.mail', true);
});

it('renders the notification channels view', function (): void {
    actingAs(User::factory()->create());

    livewire(ManageNotificationChannelsComponent::class)
        ->assertViewIs('livewire.app.profile.manage-notification-channels-component');
});

it('updates the user mail notification channel', function (): void {
    actingAs($user = User::factory()->create([
        'notification_channels' => ['mail' => false],
    ]));

    livewire(ManageNotificationChannelsComponent::class)
        ->set('form.modelData.mail', true)
        ->call('saveItem')
        ->assertHasNoErrors()
        ->assertDispatched('saved');

    expect($user->refresh()->notification_channels['mail'])->toBe(true);
});
