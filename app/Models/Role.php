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
        'viewAny' => false,
        'view' => false,
        'create' => false,
        'update' => false,
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
        ],
        \App\Models\Setting\Setting::class => [
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'manageables' => 'array',
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

        $role->manageables = json_decode($role->manageables);

        return $role;
    }

    /**
     * Update role
     *
     * @param array $attributes
     * @param array $options
     * @return Role
     */
    public function update($attributes = [], $options = [])
    {
        $attributes = [
            ...$attributes,
            'manageables' => self::addExistingUncontainedManageables($attributes['manageables']),
        ];

        parent::update($attributes, $options);

        return $this;
    }

    /**
     * Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check permission
     *
     * @param string $action
     * @param string $manageableClass
     * @return bool
     */
    public function hasPermission(string $action, string $manageableClass)
    {
        if ($this->is_super) {
            return true;
        }

        $manageable = ((array) $this->manageables)[self::classNameToManageableName($manageableClass)] ?? null;
        return $manageable ? ((array) $manageable)[$action] ?? false : false;
    }

    /**
     * Is super user role
     *
     * @return bool
     */
    public function isSuperRole()
    {
        return $this->is_super;
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function (Role $role) {
            $role->manageables = self::addExistingUncontainedManageables($role->manageables);
        });
    }

    /**
     * 
     * Checks whether one or more manageables defined in the 'manageables' constant are contained in '$manageables' or not.
     * It will be added if not contained.
     *
     * @param array $manageables
     * @return array
     */
    protected static function addExistingUncontainedManageables(array $manageables)
    {
        foreach (self::getManageables() as $key => $manageable) {
            if (!key_exists($key, $manageables)) {
                $manageables[$key] = $manageable;
            }
        }

        return $manageables;
    }

    /**
     * Get manageables
     *
     * @return array
     */
    public static function getManageables()
    {
        $manageables = [];

        foreach (self::manageables as $manageable => $manageableActions) {
            $manageables[self::classNameToManageableName($manageable)] = $manageableActions;
        }

        return $manageables;
    }

    /**
     * Class name to manageable name
     *
     * @param string $className
     * @return string
     */
    private static function classNameToManageableName(string $className)
    {
        return str_replace('\\', '_', $className);
    }
}
