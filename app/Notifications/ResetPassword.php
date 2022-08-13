<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as Notification;

class ResetPassword extends Notification
{
    public function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(config('app.client_url') . '/password/reset/' .
            $this->token) .
            '?email=' . $notifiable->getEmailForPasswordReset();
    }
}
