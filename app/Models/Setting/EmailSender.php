<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSender extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'name',
        'host',
        'port',
        'encrypt',
        'username',
        'password',
        'from_mail'
    ];

    protected $hidden = [
        'username',
        'password',
        'from_mail'
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
