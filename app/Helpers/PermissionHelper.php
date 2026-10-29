<?php

namespace App\Helpers;

/**
 * Single source of truth for role-based permissions.
 * Used by:
 *  - CheckPermission middleware (route-level enforcement)
 *  - PermissionServiceProvider @canDo / @cantDo Blade directives (UI-level hiding)
 */
class PermissionHelper
{
    /**
     * Permission matrix — matches the "Access and permissions preview" table.
     *
     * @var array<string, array<string, bool>>
     */
    private const MATRIX = [
        'System Administrator' => [
            'view'         => true,
            'create'       => true,
            'edit'         => true,
            'approve'      => true,
            'export'       => true,
            'manage_users' => true,
        ],
        'Team Leader' => [
            'view'         => true,
            'create'       => true,
            'edit'         => true,
            'approve'      => true,
            'export'       => true,
            'manage_users' => false,
        ],
        'Vocational Worker' => [
            'view'         => true,
            'create'       => true,
            'edit'         => true,
            'approve'      => false,
            'export'       => false,
            'manage_users' => false,
        ],
        'Student/Researcher' => [
            'view'         => true,
            'create'       => false,
            'edit'         => false,
            'approve'      => false,
            'export'       => false,
            'manage_users' => false,
        ],
        'University Management' => [
            'view'         => true,
            'create'       => false,
            'edit'         => false,
            'approve'      => true,
            'export'       => true,
            'manage_users' => false,
        ],
    ];

    /**
     * Check if the currently authenticated user has the given permission.
     * Unknown roles fall back to the most restrictive set (Student/Researcher).
     */
    public static function can(string $permission): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        // System Administrator always gets full access regardless of DB quirks
        if ($user->role === 'System Administrator') {
            return true;
        }

        $role        = $user->role ?? 'Student/Researcher';
        $permissions = self::MATRIX[$role] ?? self::MATRIX['Student/Researcher'];

        return $permissions[$permission] ?? false;
    }

    /**
     * Get the full permission set for a given role.
     *
     * @return array<string, bool>
     */
    public static function forRole(string $role): array
    {
        return self::MATRIX[$role] ?? self::MATRIX['Student/Researcher'];
    }

    /**
     * Get all defined roles.
     *
     * @return string[]
     */
    public static function roles(): array
    {
        return array_keys(self::MATRIX);
    }
}
