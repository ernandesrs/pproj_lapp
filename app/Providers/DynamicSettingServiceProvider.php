<?php

namespace App\Providers;

use App\Models\Setting\Setting;
use Illuminate\Support\ServiceProvider;

class DynamicSettingServiceProvider extends ServiceProvider {
    /**
     * Register services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void {
        self::smtpMailSetting();
    }

    /**
     * Get/create default settings
     *
     * @return \App\Models\Setting\Setting $defaultSettings
     */
    private static function defaultSetting() {
        return Setting::where('name', 'default')->firstOrCreate([
            'display_name' => 'Padrão',
            'name' => 'default'
        ]);
    }

    /**
     * 
     * SMTP MAIL SETTINGS
     * 
     */
    private static function smtpMailSetting() {
        $mailSettings = self::defaultSetting()->emailSenders(true);
        if($mailSettings) {
            config([
                'mail.mailers.smtp.host' => $mailSettings->host,
                'mail.mailers.smtp.port' => $mailSettings->port,
                'mail.mailers.smtp.encryption' => $mailSettings->encrypt,
                'mail.mailers.smtp.username' => $mailSettings->username,
                'mail.mailers.smtp.password' => $mailSettings->password,
                'mail.from.address' => $mailSettings->from_mail
            ]);

            $err = self::defaultSetting()->settingErrors()->where('type', \App\Models\Setting\EmailSender::class)->first();
            if($err) {
                $err->delete();
            }
        } else {
            /**
             * 
             * Register a error
             * 
             */
            self::defaultSetting()->settingErrors()->where('type', \App\Models\Setting\EmailSender::class)->updateOrCreate([
                'type' => \App\Models\Setting\EmailSender::class,
                'name' => self::defaultSetting()::nameMaker(\App\Models\Setting\EmailSender::class),
                'message' => 'Default email sending service not configured. Emails such as verification and invoices will not be sent.',
                'priority' => \App\Models\Setting\SettingError::PRIORITY_HIGH,
            ]);
        }
    }
}
