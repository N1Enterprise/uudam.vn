<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create(data_get($tableNames, 'permissions'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create(data_get($tableNames, 'roles'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        Schema::create(data_get($tableNames, 'model_has_permissions'), function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger(data_get($columnNames, 'model_morph_key'));
            $table->index([data_get($columnNames, 'model_morph_key'), 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', data_get($columnNames, 'model_morph_key'), 'model_type'], 'model_has_permissions_permission_model_type_primary');
        });

        Schema::create(data_get($tableNames, 'model_has_roles'), function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger(data_get($columnNames, 'model_morph_key'));
            $table->index([data_get($columnNames, 'model_morph_key'), 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', data_get($columnNames, 'model_morph_key'), 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create(data_get($tableNames, 'role_has_permissions'), function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on(data_get($tableNames, 'permissions'))
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on(data_get($tableNames, 'roles'))
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        Schema::drop(data_get($tableNames, 'role_has_permissions'));
        Schema::drop(data_get($tableNames, 'model_has_roles'));
        Schema::drop(data_get($tableNames, 'model_has_permissions'));
        Schema::drop(data_get($tableNames, 'roles'));
        Schema::drop(data_get($tableNames, 'permissions'));
    }
}
