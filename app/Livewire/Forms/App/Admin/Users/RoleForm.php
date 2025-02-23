<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Admin\Users;

use App\Actions\App\Admin\Roles\CreateRoleAction;
use App\Actions\App\Admin\Roles\UpdateRoleAction;
use App\Enums\Users\RoleGuardEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Throwable;

final class RoleForm extends Form
{
    /**
     * @var array<string, mixed>
     */
    public array $modelData = [];

    public function setFormData(?Role $role = null): void
    {
        $this->modelData = $role instanceof Role
            ? [
                'name' => $role->name,
                'guard_name' => $role->guard_name,
            ]
            : [];
    }

    /**
     * @throws Throwable
     */
    public function save(?Role $role = null): ?Role
    {
        $this->validate();

        $duplicatedRoleExists = Role::query()
            ->where('name', $this->modelData['name'])
            ->where('guard_name', $this->modelData['guard_name'])
            ->when($role, fn (Builder $query) => $query->whereKeyNot($role?->getKey()))
            ->exists();

        if ($duplicatedRoleExists) {
            $this->addError('modelData.name', __('roles.validation.name.unique', [
                'attribute' => __('roles.form.name'),
            ]));

            return null;
        }

        return $role instanceof Role ? $this->updateRecord($role) : $this->storeRecord();
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modelData.name.required' => __('roles.validation.name.required'),
            'modelData.name.string' => __('roles.validation.name.string'),
            'modelData.name.max' => __('roles.validation.name.max'),
            'modelData.guard_name.required' => __('roles.validation.guard_name.required'),
            'modelData.guard_name.string' => __('roles.validation.guard_name.string'),
            'modelData.guard_name.max' => __('roles.validation.guard_name.max'),
            'modelData.guard_name.enum' => __('roles.validation.guard_name.enum'),
        ];
    }

    /**
     * @return array<string, array<array-key, mixed>>
     */
    protected function rules(): array
    {
        return [
            'modelData.name' => ['required', 'string', 'max:100'],
            'modelData.guard_name' => ['required', 'string', 'max:25', Rule::enum(RoleGuardEnum::class)],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        /** @var array<string, string> $validationAttributes */
        $validationAttributes = collect([
            'modelData.name' => __('roles.form.name'),
            'modelData.guard_name' => __('roles.form.guard_name'),
        ])->map(fn (string $value, string $key): array => [$key => Str::lower($value)])->collapse()->toArray();

        return $validationAttributes;
    }

    /**
     * @throws Throwable
     */
    private function storeRecord(): Role
    {
        return (new CreateRoleAction)->execute($this->modelData);
    }

    /**
     * @throws Throwable
     */
    private function updateRecord(Role $role): Role
    {
        return (new UpdateRoleAction)->execute($role, $this->modelData);
    }
}
