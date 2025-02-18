<?php

declare(strict_types=1);

namespace App\Livewire\App\Admin\Users;

use App\Actions\Jetstream\DeleteUser;
use App\Enums\Users\DefaultRoleEnum;
use App\Livewire\Forms\App\Admin\Users\UserForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

final class UserManagementComponent extends Component
{
    use WithPagination;

    public UserForm $form;

    /**
     * @var Collection<int, Role>
     */
    public Collection $roles;

    public int $itemsPerPage = 10;

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    #[Url(as: 'role', except: 'not_set')]
    public string $selectedRole = 'not_set';

    #[Url(as: 's', except: '')]
    public string $search = '';

    public bool|int $confirmingItemManage = false;

    public bool|int $confirmingItemDeletion = false;

    public function mount(): void
    {
        abort_if(
            ! auth()->user()?->hasAnyRole(DefaultRoleEnum::SUPER_ADMIN->value, DefaultRoleEnum::ADMIN->value),
            403
        );

        $this->roles = Role::query()->orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.app.admin.user.user-management-component', [
            'users' => User::query()
                ->with(['roles'])
                ->where(function (Builder $query): void {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->when($this->selectedRole !== 'not_set', function (Builder $query): void {
                    $query->whereHas('roles', function (Builder $query): void {
                        $query->where('id', (int) $this->selectedRole);
                    });
                })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->itemsPerPage),
        ]);
    }

    public function updated(string $property): void
    {
        if (in_array($property, ['selectedRole', 'search'])) {
            $this->resetPage();
        }
    }

    public function confirmItemAdd(): void
    {
        $this->form->setFormData();
        $this->confirmingItemManage = true;
    }

    public function confirmItemEdit(User $user): void
    {
        $this->form->setFormData($user);
        $this->confirmingItemManage = $user->id;
    }

    public function saveRecord(): void
    {
        $recordId = $this->form->modelData['id'] ?? null;
        $this->form->save();
        $this->confirmingItemManage = false;
        $this->dispatch(event: 'swal:alert', type: 'success', title: $recordId
            ? __('common.flash_messages.updated')
            : __('common.flash_messages.created')
        );
    }

    public function confirmItemDeletion(User $user): void
    {
        $this->confirmingItemDeletion = $user->id;
    }

    public function deleteRecord(User $user): void
    {
        app(DeleteUser::class)->delete($user);
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
