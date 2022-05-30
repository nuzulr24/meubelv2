<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
 
    public $uname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($uname)
    {
        $this->uname = $uname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('email.welcome');
        return 'haha';
    }
}
?>