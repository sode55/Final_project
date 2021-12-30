<?php

namespace App\Services;

use App\Interfaces\SendMessageInterface;
use Illuminate\Support\Facades\Mail;

class MessageService implements SendMessageInterface
{
    public function sendEmail($name, $email, $ticket)
    {
        $to_name = $name;
        $to_email = $email;
        $data = ['name' => 'booking.test',  'body' => $ticket];
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->from("s.h.brainy@gmail.com");
            $message->to($to_email, $to_name)->subject("your ticket");
            });
    }
}
