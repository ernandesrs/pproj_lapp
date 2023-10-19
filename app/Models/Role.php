<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * Default manageables actions
     *
     * @var array
     */
    public const defaultManageablesActions = [
        'list' => false,
        'show' => false,
        'create' => false,
        'edit' => false,
        'delete' => false
    ];

    /**
     * Manageables
     *
     * @var array
     */
    public const manageables = [
        \App\Models\User::class => [
            ...self::defaultManageablesActions,
            'edit_admins' => false,
            'delete_admins' => false
        ],
        \App\Models\Role::class => [
            ...self::defaultManageablesActions
        ]
    ];

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'is_super',
        'protected',
        'manageables'
    ];

    /**
     * Create
     *
     * @param array $attributes
     * @return Role
     */
    public static function create(array $attributes = [])
    {
        $attributes = [
            'name' => $attributes['name'],
            'is_super' => $attributes['is_super'] ?? false,
            'protected' => $attributes['protected'] ?? false,
            'manageables' => json_encode($attributes['manageables'] ?? self::getManageables())
        ];

        $role = new Role($attributes);
        $role->save();

        return $role;
    }

    /**
     * Get manageables
     *
     * @return array
     */
    private static function getManageables()
    {
        $manageables = [];

        foreach (self::manageables as $manageable => $manageableActions) {
            $manageables[str_replace('\\', '_', $manageable)] = $manageableActions;
        }

        return $manageables;
    }
}