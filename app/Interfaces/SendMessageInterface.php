<?php

namespace App\Interfaces;

interface SendMessageInterface
{
    public function sendEmail($name, $email, $ticket);
}
