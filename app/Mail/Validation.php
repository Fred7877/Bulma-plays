<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class Validation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $signedUrl = URL::temporarySignedRoute('email.validation', now()->addMinutes(30), ['user' => $this->user->id]);

        return $this->from('bulmaplayz@gmail.com')
            ->subject(trans('frontend.email_validation'))
            ->view('emails.validation',
                [
                    'signedUrl' => $signedUrl
                ]
            );
    }
}
