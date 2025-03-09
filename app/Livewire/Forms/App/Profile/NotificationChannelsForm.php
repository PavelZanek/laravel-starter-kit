<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Profile;

use Livewire\Form;

final class NotificationChannelsForm extends Form
{
    /**
     * @var array<string, mixed>
     */
    public array $modelData = [];

    public function setFormData(): void
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $this->modelData = [
            'mail' => $user->notification_channels['mail'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modelData.mail.boolean' => __('profile.preferred_locale_form.request.update.preferred_locale.required'),
        ];
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(): void
    {
        /** @var array<string, array<string, string>> $validated */
        $validated = $this->validate([
            'modelData.mail' => ['boolean'],
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $notificationChannels = $user->notification_channels;
        $notificationChannels['mail'] = $validated['modelData']['mail'] ?? false;

        $user->update([
            'notification_channels' => $notificationChannels,
        ]);
    }
}
