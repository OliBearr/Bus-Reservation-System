<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactQuery extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->to('busph.help@gmail.com')
            ->replyTo($this->data['email'], $this->data['name'])
            ->subject($this->data['subject'])
            ->view('emails.contact')
            ->with($this->data);
    }
}
