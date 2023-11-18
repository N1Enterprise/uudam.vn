<?php

namespace App\Services;

use App\Repositories\Contracts\RoleRepositoryContract;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService
{
    public $roleRepository;
    public $guardName = 'admin';

    public static $groupedPermissions = [
        'users' => [
            'users.index',
            'label_users_detail' => [
                'users.show',
                'users.update',
                'label_users_detail_action' => [
                    'users.set-test-user',
                    'users.action',
                ],
            ],
        ],
        'catalogs' => [
            'category-groups' => [
                'category-groups.index',
                'category-groups.store',
                'category-groups.update',
                'category-groups.delete',
            ],
            'categories' => [
                'categories.index',
                'categories.store',
                'categories.update',
                'categories.delete',
            ],
            'products' => [
                'products.index',
                'products.store',
                'products.update',
                'products.delete',
            ],
            'product-combos' => [
                'product-combos.index',
                'product-combos.store',
                'product-combos.update',
                'product-combos.delete',
            ],
            'attributes' => [
                'attributes.index',
                'attributes.store',
                'attributes.update',
                'attribute-values' => [
                    'attribute-values.index',
                    'attribute-values.store',
                    'attribute-values.update',
                    'attribute-values.delete',
                ],
            ],
        ],
        'stocks' => [
            'inventories' => [
                'inventories.index',
                'inventories.store',
                'inventories.update',
                'inventories.delete',
            ],
        ],
        'systems' => [
            'system-settings' => [
                'system-settings.index',
                'system-settings.store',
                'system-settings.update',
                'system-settings.create-group',
                'system-settings.create-key',
                'system-settings.delete',
                'system-settings.clear-cache',
                'system-settings.import',
                'system-settings.export'
            ],
        ],
        'admin-users' => [
            'admins' => [
                'admins.index',
                'admins.store',
                'admins.update',
                'admins.export'
            ],
            'roles' => [
                'roles.index',
                'roles.store',
                'roles.update'
            ],
        ],
        'support-desks' => [
            'product-reviews' => [
                'product-reviews.index',
                'product-reviews.store',
                'product-reviews.update',
                'product-reviews.delete',
            ],
            'subscribers' => [
                'subscribers.index',
                'subscribers.manage',
            ],
        ],
        'appearances' => [
            'display-inventories' => [
                'display-inventories.index',
                'display-inventories.store',
                'display-inventories.update',
                'display-inventories.delete',
            ],
            'banners' => [
                'banners.index',
                'banners.store',
                'banners.update',
                'banners.delete',
            ],
            'menus' => [
                'menus.index',
                'menus.store',
                'menus.update',
                'menus.delete',
                'menu-groups' => [
                    'menu-groups.index',
                    'menu-groups.store',
                    'menu-groups.update',
                    'menu-groups.delete',
                ],
                'menu-sub-groups' => [
                    'menu-sub-groups.index',
                    'menu-sub-groups.store',
                    'menu-sub-groups.update',
                    'menu-sub-groups.delete',
                ],
            ],
            'collections' => [
                'collections.index',
                'collections.store',
                'collections.update',
                'collections.delete',
            ],
        ],
        'shippings' => [
            'carriers' => [
                'carriers.index',
                'carriers.store',
                'carriers.update',
            ],
        ],
        'utilities' => [
            'blogs' => [
                'post-categories' => [
                    'post-categories.index',
                    'post-categories.store',
                    'post-categories.update',
                    'post-categories.delete',
                ],
                'posts' => [
                    'posts.index',
                    'posts.store',
                    'posts.update',
                    'posts.delete',
                ],
            ],
            'pages' => [
                'pages.index',
                'pages.store',
                'pages.update',
                'pages.delete',
            ],
            'faqs' => [
                'faqs.index',
                'faqs.store',
                'faqs.update',
                'faqs.delete',
                'topics' => [
                    'faq-topics.index',
                    'faq-topics.store',
                    'faq-topics.update',
                    'faq-topics.delete',
                ],
            ],
        ],
    ];

    public function __construct(RoleRepositoryContract $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function searchByAdmin(array $data = [])
    {
        $result = $this->roleRepository->withCount(['users'])
            ->scopeQuery(function ($q) {
                $q->where('guard_name', $this->guardName);
            })
            ->whereColumnsLike($data['query'] ?? null, ['name'])
            ->search([]);

        return $result;
    }

    public function all()
    {
        return $this->roleRepository->scopeQuery(function ($q) {
            $q->where('guard_name', $this->guardName);
        })->all();
    }

    public static function getGroupedPermissions()
    {
        $systemPermissions = app(config('permission.models.permission'))::getPermissions(['guard_name' => 'admin'])->pluck('name')->all();

        $groupedPermissions = static::$groupedPermissions;

        $otherPermissions = array_diff($systemPermissions, Arr::flatten($groupedPermissions));

        $redundantPermissions = array_diff(Arr::flatten($groupedPermissions), $systemPermissions);

        $redundantKeys = collect(Arr::dot($groupedPermissions))
            ->filter(function($permission) use ($redundantPermissions) {
                return in_array($permission, $redundantPermissions);
            });

        Arr::forget($groupedPermissions, $redundantKeys->keys()->toArray());

        if (empty($otherPermissions)) {
            return $groupedPermissions;
        }

        return array_merge($groupedPermissions, [
            'label_others' => $otherPermissions
        ]);
    }

    public function create(array $attributes = [])
    {
        return DB::transaction(function() use ($attributes) {
            $attributes['guard_name'] = $this->guardName;

            $role = $this->roleRepository->create(Arr::only($attributes, ['name', 'guard_name']));

            $permissions = array_keys(Arr::get($attributes, 'permissions'));

            $role->syncPermissions($permissions);

            return $role;
        });
    }

    public function show($id)
    {
        return $this->roleRepository->findOrFail($id);
    }

    public function update($attributes = [], $id)
    {
        try {
            return DB::transaction(function () use ($attributes, $id) {
                $attributes['guard_name'] = $this->guardName;

                $role = $this->roleRepository->update(Arr::only($attributes, ['name', 'guard_name']), $id);

                $permissions = array_keys(Arr::get($attributes, 'permissions', []));

                $role->syncPermissions($permissions);

                return $role;
            });
        } catch (\Throwable $th) {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

            throw $th;
        }
    }
}
