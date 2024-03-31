<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerifyEmailWithCode extends VerifyEmail
{
    public function toMail($notifiable)
    {
        $user = User::find($notifiable->id);
        $verificationCode = $user->verification_code;

        return (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Please click the button below to verify your email address.')
            ->action('Verify Email Address', $this->verificationUrl($notifiable))
            ->line('Your verification code is: ' . $verificationCode)
            ->line('If you did not create an account, no further action is required.');
    }
}
