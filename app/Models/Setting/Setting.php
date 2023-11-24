<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'name'
    ];

    /**
     * settingErrors
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settingErrors()
    {
        return $this->hasMany(SettingError::class);
    }

    /**
     * Get email senders
     *
     * @param boolean $onlyDefault true to get only default email sender
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|EmailSender|null
     */
    public function emailSenders(bool $onlyDefault = false)
    {
        $hasMany = $this->hasMany(EmailSender::class);
        return $onlyDefault ? $hasMany->where('default', '=', true)->first() : $hasMany;
    }

    /**
     * Name maker
     *
     * @param string $class
     * @return string
     */
    public static function nameMaker(string $class)
    {
        return strtolower(str_replace(['\\'], '_', $class)) . '_error';
    }
}
