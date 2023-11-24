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
        /**
         * @var \App\Models\Setting\Setting $defaultSettings
         */
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

            $err = $defaultSettings->settingErrors()->where('type', \App\Models\Setting\EmailSender::class)->first();
            if ($err) {
                $err->delete();
            }
        } else {
            /**
             * 
             * Register a error
             * 
             */
            $defaultSettings->settingErrors()->where('type', \App\Models\Setting\EmailSender::class)->updateOrCreate([
                'type' => \App\Models\Setting\EmailSender::class,
                'name' => $defaultSettings::nameMaker(\App\Models\Setting\EmailSender::class),
                'message' => 'Default email sending service not configured. Emails such as verification and invoices will not be sent.',
                'priority' => \App\Models\Setting\SettingError::PRIORITY_HIGH,
            ]);
        }
    }
}
