<?php

declare(strict_types=1);

namespace App\Livewire\App\Profile;

use App\Enums\Users\PreferredLocaleEnum;
use App\Livewire\Forms\App\Profile\PreferredLocaleForm;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class ManagePreferredLocaleComponent extends Component
{
    public PreferredLocaleForm $form;

    public function mount(): void
    {
        $this->form->setFormData();
    }

    public function render(): View
    {
        return view('livewire.app.profile.manage-preferred-locale-component', [
            'preferredLocales' => PreferredLocaleEnum::all(),
        ]);
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
