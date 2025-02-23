<?php

declare(strict_types=1);

namespace App\Livewire\App\Admin\Users\Roles;

use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\Forms\App\Admin\Users\RoleForm;
use App\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

final class CreateRoleComponent extends Component
{
    public RoleForm $form;

    /**
     * @var array<string, array<int, array<string, mixed>>>
     */
    public array $permissions;

    /**
     * @var Collection<int, array<string, string>>
     */
    public Collection $roleGuards;

    public bool $confirmingItemDeletion = false;

    public function mount(): void
    {
        abort_if(
            ! auth()->user()?->hasAnyRole(DefaultRoleEnum::SUPER_ADMIN->value, DefaultRoleEnum::ADMIN->value),
            403
        );

        $this->roleGuards = RoleGuardEnum::all();

        $this->permissions = Permission::getPermissionSelectList();

        $this->form->setFormData();
    }

    public function render(): View
    {
        return view('livewire.app.admin.users.roles.role-form-component');
    }

    /**
     * @throws Throwable
     */
    public function saveRecord(): void
    {
        $role = $this->form->save();

        if ($role instanceof \App\Models\Role) {
            $this->dispatch('saved');
            $this->dispatch(event: 'swal:alert', type: 'success', title: __('common.flash_messages.created'));

            $this->redirect(route('admin.roles.index'), navigate: true);
        }
    }
}
