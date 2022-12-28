<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PunchFinishCheckMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $kintais, $nowDate)
    {
        $this->name = $name;
        $this->email = $email;
        $this->kintais = $kintais;
        $this->nowDate = $nowDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->to($this->email)
        ->subject('【Touch】未退勤情報@'.$this->nowDate)
        ->view('mail.punch_finish_check')
        ->with([
            'name' => $this->name,
            'kintais' => $this->kintais,
        ]);
    }
}
