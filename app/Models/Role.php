<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\PermissionRegistrar;

/**
 * @mixin IdeHelperRole
 */
final class Role extends SpatieRole
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'guard_name',
        'is_default',
    ];

    /**
     * A role belongs to some users of the model associated with its guard.
     *
     * @return BelongsToMany<User, $this>
     */
    #[Override]
    public function users(): BelongsToMany
    {
        /** @var string $modelHasRoles */
        $modelHasRoles = config('permission.table_names.model_has_roles');

        /** @var string $modelMorphKey */
        $modelMorphKey = config('permission.column_names.model_morph_key');

        return $this->morphedByMany(
            User::class,
            'model',
            $modelHasRoles,
            app(PermissionRegistrar::class)->pivotRole,
            $modelMorphKey
        );
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }
}
