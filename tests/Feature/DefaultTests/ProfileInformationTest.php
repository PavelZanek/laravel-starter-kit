<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;

test('current profile information is available', function (): void {
    $this->actingAs($user = User::factory()->create());

    $component = Livewire::test(UpdateProfileInformationForm::class);

    expect($component->state['name'])->toEqual($user->name);
    expect($component->state['email'])->toEqual($user->email);
});

test('profile information can be updated', function (): void {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(UpdateProfileInformationForm::class)
        ->set('state', ['name' => 'Test Name', 'email' => 'test@example.com'])
        ->call('updateProfileInformation');

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});

test('profile photo can be updated', function (): void {
    Storage::fake('public');

    $this->actingAs($user = User::factory()->create());

    $photo = UploadedFile::fake()->image('profile.jpg');

    Livewire::test(UpdateProfileInformationForm::class)
        ->set('state.name', $user->name)  // Set individual fields instead of overriding state
        ->set('state.email', $user->email)
        ->set('photo', $photo) // Set photo separately
        ->call('updateProfileInformation');

    // Ensure the photo was uploaded and profile photo updated
    expect($user->fresh()->profile_photo_path)->not->toBeNull();
});
