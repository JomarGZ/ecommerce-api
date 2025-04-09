<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Enums\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as PermissionModel;
use Spatie\Permission\Models\Role as RoleModel;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permission::cases() as $permission) {
            PermissionModel::firstOrCreate([
                'name' => $permission->value,
            ]);
        }

        foreach (Role::cases() as $role) {
            $roleModel = RoleModel::firstOrCreate([
                'name' => $role->value,
            ]);

            $permissions = $this->AssignPermissionsToRoles($role->value);
            if (!empty($permissions)) {
                $roleModel->syncPermissions($permissions);
            }
       
        }
    }

    protected function AssignPermissionsToRoles(string $role)
    {
        if (empty($role)) {
            throw new \InvalidArgumentException("Role cannot be empty");
        }
        return match($role) {
            Role::ADMIN->value => [
                Permission::CREATE_PRODUCT,
                Permission::UPDATE_PRODUCT,
                Permission::DELETE_PRODUCT,
            ],
            Role::CUSTOMER->value => [],
            default => throw new \InvalidArgumentException("Unknown role: $role")
        };
    }
}
