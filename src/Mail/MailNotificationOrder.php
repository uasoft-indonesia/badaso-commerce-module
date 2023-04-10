<?php

namespace Uasoft\Badaso\Module\Commerce\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailNotificationOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $title;
    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $title, $content)
    {
        $this->user = $user;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('badaso_commerce::mail.order-notification');
    }
}
