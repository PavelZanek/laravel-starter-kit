<?php

declare(strict_types=1);

namespace App\Livewire\App\Profile;

use App\Livewire\Forms\App\Profile\NotificationChannelsForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ManageNotificationChannelsComponent extends Component
{
    public NotificationChannelsForm $form;

    public function mount(): void
    {
        $this->form->setFormData();
    }

    public function render(): View
    {
        return view('livewire.app.profile.manage-notification-channels-component');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveItem(): void
    {
        $this->form->save();

        $this->dispatch('saved');
    }
}
