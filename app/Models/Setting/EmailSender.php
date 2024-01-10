<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSender extends Model
{
    use HasFactory;

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'name',
        'host',
        'port',
        'default',
        'encrypt',
        'username',
        'password',
        'from_mail'
    ];

    /**
     * Hidden fields
     *
     * @var array
     */
    protected $hidden = [
        'password',
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
