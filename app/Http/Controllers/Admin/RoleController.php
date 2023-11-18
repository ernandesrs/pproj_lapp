<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TraitApiController;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use TraitApiController;

    /**
     * List roles
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Role::class);

        $roles = (new \App\Filters\RoleFilter($request))->filter();

        return $this->success([
            'roles' => $this->resourceCollection(RoleResource::class, $roles),
        ]);
    }

    /**
     * Store a role
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(RoleRequest $request)
    {
        $this->authorize('create', Role::class);

        $validated = $request->validated();

        return $this->success([
            'role' => $this->resource(RoleResource::class, Role::create($validated)),
        ]);
    }

    /**
     * Show a role
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        return $this->success([
            'role' => $this->resource(RoleResource::class, $role)
        ]);
    }

    /**
     * Update a role
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->authorize('update', $role);

        return $this->success([
            'role' => $role->update($request->validated())
        ]);
    }

    /**
     * Delete a role
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        if ($count = $role->users()->count()) {
            throw new \App\Exceptions\Admin\HasDependentsException("Can't delete, " . $count . " users are linked to this role.");
        }

        $role->delete();

        return $this->success();
    }
}
