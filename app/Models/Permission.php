<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;
use Spatie\Permission\Models\Permission as SpatiePermission;
use Spatie\Permission\PermissionRegistrar;

/**
 * @mixin IdeHelperRole
 */
final class Permission extends SpatiePermission
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'guard_name',
    ];

    /**
     * A role belongs to some users of the model associated with its guard.
     *
     * @return BelongsToMany<User, $this>
     */
    #[Override]
    public function users(): BelongsToMany
    {
        // @codeCoverageIgnoreStart
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
        // @codeCoverageIgnoreEnd
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
