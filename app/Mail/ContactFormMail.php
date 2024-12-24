<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $message;

    public function __construct($name, $email, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject($this->name)  // Tiêu đề email sẽ là tên người gửi
                    ->from($this->email)   // Email gửi từ email của người dùng
                    ->view('emails.contact-form');  // View hiển thị nội dung email
    }
}
