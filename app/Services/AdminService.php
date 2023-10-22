<?php

namespace App\Services;

use App\Repositories\Contracts\AdminRepositoryContract;
use Illuminate\Support\Facades\DB;

class AdminService extends BaseService
{
    public $adminRepository;

    public function __construct(AdminRepositoryContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function searchByAdmin($data = [])
    {
        $result = $this->adminRepository->withTrashed()->with('roles')
            ->whereColumnsLike($data['query'] ?? null, ['name', 'email'])
            ->search([]);

        return $result;
    }

    public function show($id)
    {
        return $this->adminRepository->withTrashed()->findOrFail($id, ['*'], true);
    }

    public function create($attributes = [])
    {
        return DB::transaction(function () use ($attributes) {
            $admin = $this->adminRepository->create($attributes);

            $admin->syncRoles(array_keys($attributes['roles']));

            return $admin;
        });
    }

    public function update($attributes = [], $id)
    {
        return DB::transaction(function () use ($attributes, $id) {
            $admin = $this->adminRepository->withTrashed()->update(array_filter($attributes), $id);

            if (isset($attributes['roles'])) {
                $admin->syncRoles(array_keys($attributes['roles']));
            }

            return $admin;
        });
    }

    public function deactivate($id)
    {
        $deleted = $this->adminRepository->delete($id);

        return $deleted;
    }

    public function active($id)
    {
        $admin = $this->adminRepository->restore($id);

        return $admin;
    }

    public function getUsersHasPermissions($permissions)
    {
        $permissions = ! is_array($permissions) ? [$permissions] : $permissions;

        return $this->adminRepository->whereHas('roles.permissions', function ($q) use ($permissions) {
            $q->whereIn('name', $permissions);
        })->get();
    }

    public function guardName()
    {
        return 'admin';
    }
}
