<?php

declare(strict_types=1);

use App\Enums\Users\PreferredLocaleEnum;
use App\Livewire\App\Profile\ManagePreferredLocaleComponent;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('initializes the form with the current user preferred locale', function (): void {
    actingAs(User::factory()->create([
        'preferred_locale' => $defaultPreferredLocale = PreferredLocaleEnum::EN->value,
    ]));

    livewire(ManagePreferredLocaleComponent::class)
        ->assertSet('form.modelData.preferred_locale', $defaultPreferredLocale);
});

it('passes available preferred locales to the view', function (): void {
    actingAs(User::factory()->create());

    livewire(ManagePreferredLocaleComponent::class)
        ->assertViewHas('preferredLocales', PreferredLocaleEnum::all());
});

it('updates the user preferred locale', function (): void {
    actingAs($user = User::factory()->create([
        'preferred_locale' => PreferredLocaleEnum::EN->value,
    ]));

    $newLocale = PreferredLocaleEnum::CS;

    livewire(ManagePreferredLocaleComponent::class)
        ->set('form.modelData.preferred_locale', $newLocale->value)
        ->call('saveItem')
        ->assertHasNoErrors()
        ->assertDispatched('saved');

    expect($user->refresh())
        ->preferred_locale->value->toBe($newLocale->value);
});
