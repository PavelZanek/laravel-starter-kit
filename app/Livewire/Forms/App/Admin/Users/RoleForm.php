<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Admin\Users;

use App\Actions\App\Admin\Roles\CreateRoleAction;
use App\Actions\App\Admin\Roles\UpdateRoleAction;
use App\Enums\Users\RoleGuardEnum;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;

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
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
            ]
            // @codeCoverageIgnoreStart
            : [];
        // @codeCoverageIgnoreEnd
    }

    public function save(): Role
    {
        $this->validate();

        $role = isset($this->modelData['id']) ? $this->updateRecord() : $this->storeRecord();

        $this->reset(['modelData']);

        return $role;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modelData.name.required' => __('roles.index.validation.name.required'),
            'modelData.name.string' => __('roles.index.validation.name.string'),
            'modelData.name.max' => __('roles.index.validation.name.max'),
            'modelData.guard_name.required' => __('roles.index.validation.guard_name.required'),
            'modelData.guard_name.string' => __('roles.index.validation.guard_name.string'),
            'modelData.guard_name.max' => __('roles.index.validation.guard_name.max'),
            'modelData.guard_name.enum' => __('roles.index.validation.guard_name.enum'),
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
            'modelData.name' => __('roles.index.form.name'),
            'modelData.guard_name' => __('roles.index.form.guard_name'),
        ])->map(fn (string $value, string $key): array => [$key => Str::lower($value)])->collapse()->toArray();

        return $validationAttributes;
        //        TODO
        //        return __('roles.index.form.');
    }

    private function storeRecord(): Role
    {
        return (new CreateRoleAction)->execute($this->modelData);
    }

    private function updateRecord(): Role
    {
        /** @var Role $role */
        $role = Role::query()->findOrFail($this->modelData['id']);

        unset($this->modelData['id']);

        return (new UpdateRoleAction)->execute($role, $this->modelData);
    }
}
