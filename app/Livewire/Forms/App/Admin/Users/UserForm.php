<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Admin\Users;

use App\Actions\App\Admin\Users\CreateUserAction;
use App\Actions\App\Admin\Users\UpdateUserAction;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Spatie\Permission\Models\Role;

final class UserForm extends Form
{
    /**
     * @var array<string, mixed>
     */
    public array $modelData = [];

    /**
     * @var array<string, mixed>
     */
    public array $relations = [];

    public function setFormData(?User $user = null): void
    {
        $this->modelData = $user instanceof User
            ? ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]
            // @codeCoverageIgnoreStart
            : [];
        // @codeCoverageIgnoreEnd

        $this->relations = [
            'role' => $user?->roles->first()->id ?? null,
        ];
    }

    public function save(): User
    {
        $this->validate();

        /** @var Role $role */
        $role = Role::query()->findOrFail($this->relations['role']);

        $user = isset($this->modelData['id']) ? $this->updateRecord($role) : $this->storeRecord($role);

        $this->reset(['modelData', 'relations']);

        return $user;
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modelData.name.required' => __('users.index.validation.name.required'),
            'modelData.name.string' => __('users.index.validation.name.string'),
            'modelData.name.max' => __('users.index.validation.name.max'),
            'modelData.email.required' => __('users.index.validation.email.required'),
            'modelData.email.email' => __('users.index.validation.email.email'),
            'modelData.email.max' => __('users.index.validation.email.max'),
            'modelData.email.unique' => __('users.index.validation.email.unique'),
            'relations.role.required' => __('users.index.validation.role.required'),
            'relations.role.numeric' => __('users.index.validation.role.numeric'),
            'relations.role.exists' => __('users.index.validation.role.exists'),
        ];
    }

    /**
     * @return array<string, array<array-key, mixed>>
     */
    protected function rules(): array
    {
        return [
            'modelData.name' => ['required', 'string', 'max:150'],
            'modelData.email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->modelData['id'] ?? null)],
            'relations.role' => ['required', 'numeric', 'exists:roles,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function validationAttributes(): array
    {
        /** @var array<string, string> $validationAttributes */
        $validationAttributes = collect([
            'modelData.name' => __('users.index.form.name'),
            'modelData.email' => __('users.index.form.email'),
            'relations.role' => __('users.index.form.role'),
        ])->map(fn (string $value, string $key): array => [$key => Str::lower($value)])->collapse()->toArray();

        return $validationAttributes;
    }

    private function storeRecord(Role $role): User
    {
        return (new CreateUserAction)->execute($this->modelData, $role);
    }

    private function updateRecord(Role $role): User
    {
        /** @var User $user */
        $user = User::query()->findOrFail($this->modelData['id']);

        unset($this->modelData['id']);

        return (new UpdateUserAction)->execute($user, $this->modelData, $role);
    }
}
