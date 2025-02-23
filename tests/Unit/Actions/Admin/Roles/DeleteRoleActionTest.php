<?php

declare(strict_types=1);

use App\Actions\App\Admin\Roles\DeleteRoleAction;
use App\Models\Role;

use function Pest\Laravel\assertDatabaseMissing;

it('can delete a record', function (): void {
    $model = Role::factory()->create();

    (new DeleteRoleAction)->execute($model);

    assertDatabaseMissing('roles', [
        'id' => $model->id,
    ]);
});
