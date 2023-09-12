<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as BaseRoleEntity;

class Role extends BaseRoleEntity
{
    protected $fillable = [
        'name',
        'guard_name',
    ];

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }

    public function getCreatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->created_at);
    }

    public function getUpdatedAtLocalizedAttribute()
    {
        return convert_datetime_To_client_time($this->updated_at);
    }

    protected function getDefaultGuardName(): string
    {
        return $this->guard_name;
    }

    public function users(): BelongsToMany
    {
        return $this->morphedByMany(
            Admin::class,
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            config('permission.column_names.model_morph_key')
        );
    }
}
