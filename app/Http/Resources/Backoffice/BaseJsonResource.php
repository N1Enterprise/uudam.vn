<?php

namespace App\Http\Resources\Backoffice;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Classes\AdminAuth;
use App\Http\Resources\BaseJsonResource as CoreBaseJsonResource;

abstract class BaseJsonResource extends CoreBaseJsonResource
{
    protected function getAllPermissions($permissionNamePrefix = null, $user = null)
    {
        if (! $user) {
            $user = AdminAuth::user();
        }

        $permissionNamePrefix = $this->resolvePermissionNamePrefix($permissionNamePrefix);

        if (! method_exists($user, 'getPermissionByPrefix')) {
            return [];
        }

        $permissions = $user->getPermissionByPrefix($permissionNamePrefix);

        $permissions = $permissions->keyBy(function ($permission) {
            return Str::afterLast($permission, '.');
        });

        return $permissions->toArray();
    }

    protected function getStandalonePermissions($permissionNamePrefix = null, $user = null)
    {
        return Arr::only($this->getAllPermissions($permissionNamePrefix, $user), ['show', 'update', 'delete']);
    }

    protected function getPermissionByAction($action, $permissionNamePrefix = null, $user = null)
    {
        return data_get($this->getAllPermissions($permissionNamePrefix, $user), $action);
    }

    private function resolvePermissionNamePrefix($permissionNamePrefix = null)
    {
        if (! $permissionNamePrefix) {
            if (property_exists($this, 'permissionPrefix')) {
                return $this->permissionPrefix;
            }

            $permissionNamePrefix = Str::kebab((Str::pluralStudly(Str::beforeLast(class_basename($this), 'Resource'))));
        }

        return $permissionNamePrefix;
    }
}
