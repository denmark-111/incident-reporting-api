<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class CustomResetPasswordNotification extends ResetPassword
{
    // use Queueable;

    public function toMail($notifiable)
    {
        $frontendUrl = config('app.frontend_url');

        $resetUrl = $frontendUrl . '/reset-password?token='
            . $this->token
            . '&email=' . urlencode($notifiable->email);

        return (new MailMessage)
            ->subject('Reset Your Password')
            ->view('emails.reset-password', [
                'url' => $resetUrl,
                'user' => $notifiable,
            ]);
    }
}