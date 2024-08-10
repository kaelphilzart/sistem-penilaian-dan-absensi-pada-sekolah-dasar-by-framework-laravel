<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunWaliMail extends Mailable
{
    use Queueable, SerializesModels;

    public $NISN;
    public $email;
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($NISN, $email, $password)
    {
        $this->NISN = $NISN;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.pesan-akun')
                    ->subject('Akun Wali Murid Baru')
                    ->with([
                        'NISN' => $this->NISN,
                        'email' => $this->email,
                        'password' => $this->password,
                    ]);
    }
}
