<?php

declare(strict_types=1);

namespace App\Livewire\Forms\App\Admin\Users;

use App\Actions\App\Admin\Users\CreateUserAction;
use App\Actions\App\Admin\Users\UpdateUserAction;
use App\Enums\Users\PreferredLocaleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Livewire\Form;
use Throwable;

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
            ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'preferred_locale' => $user->preferred_locale->value,
                'notification_channels' => $user->notification_channels,
            ]
            // @codeCoverageIgnoreStart
            : [];
        // @codeCoverageIgnoreEnd

        $this->relations = [
            'role' => $user?->roles->first()->id ?? null,
        ];
    }

    /**
     * @throws Throwable
     */
    public function save(): User
    {
        $this->validate();

        /** @var Role $role */
        $role = Role::query()->findOrFail($this->relations['role']);

        /** @var User $user */
        $user = auth()->user();

        $notificationChannels = $user->notification_channels;
        $notificationChannels['mail'] = $this->modelData['mail'] ?? false;

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
            'modelData.preferred_locale.required' => __('users.index.validation.preferred_locale.required'),
            'modelData.preferred_locale.string' => __('users.index.validation.preferred_locale.string'),
            'modelData.preferred_locale.max' => __('users.index.validation.preferred_locale.max'),
            'modelData.preferred_locale.enum' => __('users.index.validation.preferred_locale.enum'),
            'modelData.notification_channels.required' => __('users.index.validation.notification_channels.required'),
            'modelData.notification_channels.array' => __('users.index.validation.notification_channels.array'),
            'modelData.notification_channels.mail.required' => __('users.index.validation.notification_channels.mail.required'),
            'modelData.notification_channels.mail.boolean' => __('users.index.validation.notification_channels.mail.boolean'),
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
            'modelData.preferred_locale' => ['required', 'string', 'max:5', new Enum(PreferredLocaleEnum::class)],
            'modelData.notification_channels' => ['required', 'array'],
            'modelData.notification_channels.mail' => ['required', 'boolean'],
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
            'modelData.preferred_locale' => __('users.index.form.preferred_locale'),
            'modelData.notification_channels.mail' => __('users.index.form.mail'),
            'relations.role' => __('users.index.form.role'),
        ])->map(fn (string $value, string $key): array => [$key => Str::lower($value)])->collapse()->toArray();

        return $validationAttributes;
    }

    /**
     * @throws Throwable
     */
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
