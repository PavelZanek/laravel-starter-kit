<?php

declare(strict_types=1);

namespace App\Livewire\App\Profile;

use App\Enums\Users\PreferredLocaleEnum;
use App\Livewire\Forms\App\Profile\PreferredLocaleForm;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

final class ManagePreferredLocaleComponent extends Component
{
    public PreferredLocaleForm $form;

    /**
     * @var Collection<int, array<string, string>>
     */
    public Collection $preferredLocales;

    public function mount(): void
    {
        $this->form->setFormData();
        $this->preferredLocales = PreferredLocaleEnum::all();
    }

    public function render(): View
    {
        return view('livewire.app.profile.manage-preferred-locale-component');
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
