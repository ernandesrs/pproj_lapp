<?php

namespace App\Providers;

use App\Models\Setting\Setting;
use Illuminate\Support\ServiceProvider;

class DynamicSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $defaultSettings = Setting::where('name', 'default')->firstOrCreate([
            'display_name' => 'Padrão',
            'name' => 'default'
        ]);

        /**
         * 
         * SMTP MAIL SETTINGS
         * 
         */
        $mailSettings = $defaultSettings->emailSenders(true);
        if ($mailSettings) {
            config([
                'mail.mailers.smtp.host' => $mailSettings->host,
                'mail.mailers.smtp.port' => $mailSettings->port,
                'mail.mailers.smtp.encryption' => $mailSettings->encrypt,
                'mail.mailers.smtp.username' => $mailSettings->username,
                'mail.mailers.smtp.password' => $mailSettings->password,
                'mail.from.address' => $mailSettings->from_mail
            ]);
        }
    }
}
