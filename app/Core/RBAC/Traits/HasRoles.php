<?php

namespace App\Core\RBAC\Traits;

use App\Core\RBAC\Models\Permission;
use App\Core\RBAC\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles', 'model_id', 'role_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles->contains('name', $roleName);
    }

    public function hasPermissionTo($permissionName)
    {
        // Check direct permission (if we had direct user-permission assignment, but we stick to roles for now)
        // Check privileges via roles
        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $permissionName)) {
                return true;
            }
        }
        return false;
    }
}
