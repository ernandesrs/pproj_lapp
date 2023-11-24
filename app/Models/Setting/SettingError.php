<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingError extends Model
{
    use HasFactory;

    public const PRIORITY_LOW = 3;

    public const PRIORITY_MEDIUM = 2;

    public const PRIORITY_HIGH = 1;

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'message',
        'priority',
    ];

    /**
     * Hidden fields
     *
     * @var array
     */
    protected $hidden = [
        'type'
    ];

    /**
     * Setting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
