<?php

declare(strict_types=1);

namespace App\Livewire\App\Admin\Users\Roles;

use App\Actions\App\Admin\Roles\DeleteRoleAction;
use App\Enums\Users\DefaultRoleEnum;
use App\Enums\Users\RoleGuardEnum;
use App\Livewire\Forms\App\Admin\Users\RoleForm;
use App\Models\Role;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

final class UpdateRoleComponent extends Component
{
    public RoleForm $form;

    public Role $role;

    /**
     * @var Collection<int, array<string, string>>
     */
    public Collection $roleGuards;

    public bool $confirmingItemDeletion = false;

    public function mount(Role $role): void
    {
        abort_if(
            ! auth()->user()?->hasAnyRole(DefaultRoleEnum::SUPER_ADMIN->value, DefaultRoleEnum::ADMIN->value),
            403
        );

        $this->roleGuards = RoleGuardEnum::all();

        $this->form->setFormData($role);

        $this->role = $role;
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
        abort_if($this->role->is_default, 403);

        $role = $this->form->save($this->role);

        if ($role instanceof Role) {
            $this->dispatch('saved');
            $this->dispatch(event: 'swal:alert', type: 'success', title: __('common.flash_messages.updated'));
        }
    }

    public function confirmItemDeletion(): void
    {
        abort_if($this->role->is_default, 403);

        $this->confirmingItemDeletion = true;
    }

    public function deleteRecord(): void
    {
        abort_if($this->role->is_default, 403);

        $this->role->loadCount('users');

        if ($this->role->users_count > 0) {
            $this->dispatch(event: 'swal:alert', type: 'error', title: __('roles.delete.flash_messages.delete_error'));

            return;
        }

        (new DeleteRoleAction)->execute($this->role);

        $this->confirmingItemDeletion = false;

        $this->dispatch(event: 'swal:alert', type: 'success', title: __('common.flash_messages.deleted'));

        $this->redirect(route('admin.roles.index'), navigate: true);
    }
}
