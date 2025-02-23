<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\View\View;

final class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('app.admin.users.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('app.admin.users.roles.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        abort_if($role->is_default, 403);

        return view('app.admin.users.roles.edit', [
            'role' => $role,
        ]);
    }
}
