<?php

declare(strict_types=1);

namespace App\Livewire\App\Admin\Users\Roles;

use App\Actions\App\Admin\Roles\DeleteRoleAction;
use App\Enums\Users\DefaultRoleEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class RoleManagementComponent extends Component
{
    use WithPagination;

    public int $itemsPerPage = 10;

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    #[Url(as: 's', except: '')]
    public string $search = '';

    public bool|int $confirmingItemDeletion = false;

    public function mount(): void
    {
        abort_if(
            ! auth()->user()?->hasAnyRole(DefaultRoleEnum::SUPER_ADMIN->value, DefaultRoleEnum::ADMIN->value),
            403
        );
    }

    public function render(): View
    {
        return view('livewire.app.admin.users.roles.role-management-component', [
            'roles' => Role::query()
                ->withCount(['users'])
                ->where(function (Builder $query): void {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('guard_name', 'like', '%'.$this->search.'%');
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->itemsPerPage),
        ]);
    }

    public function updated(string $property): void
    {
        if ($property === 'search') {
            $this->resetPage();
        }
    }

    public function confirmItemDeletion(Role $role): void
    {
        abort_if($role->is_default, 403);

        /** @var int $roleId */
        $roleId = $role->id;
        $this->confirmingItemDeletion = $roleId;
    }

    public function deleteRecord(Role $role): void
    {
        abort_if((bool) $role->is_default, 403);

        $role->loadCount('users');

        if ($role->users_count > 0) {
            $this->dispatch(event: 'swal:alert', type: 'error', title: __('roles.delete.flash_messages.delete_error'));

            return;
        }

        (new DeleteRoleAction)->execute($role);

        $this->confirmingItemDeletion = false;

        $this->dispatch(event: 'swal:alert', type: 'success', title: __('common.flash_messages.deleted'));
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }
}
