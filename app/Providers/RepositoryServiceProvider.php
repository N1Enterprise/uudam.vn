<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts as Contracts;
use App\Repositories;

class RepositoryServiceProvider extends ServiceProvider
{
    public $singletons = [
        Contracts\BaseRepositoryContract::class => Repositories\BaseRepository::class,
        Contracts\RoleRepositoryContract::class => Repositories\RoleRepository::class,
        Contracts\AdminRepositoryContract::class => Repositories\AdminRepository::class,
        Contracts\UserRepositoryContract::class => Repositories\UserRepository::class,
        Contracts\UserDetailRepositoryContract::class => Repositories\UserDetailRepository::class,
        Contracts\SystemSettingRepositoryContract::class => Repositories\SystemSettingRepository::class,
        Contracts\SystemSettingGroupRepositoryContract::class => Repositories\SystemSettingGroupRepository::class,
        Contracts\CategoryGroupRepositoryContract::class => Repositories\CategoryGroupRepository::class,
        Contracts\CategoryRepositoryContract::class => Repositories\CategoryRepository::class,
    ];
}
