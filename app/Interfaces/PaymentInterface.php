<?php

namespace App\Interfaces;

interface PaymentInterface
{

public function request($amount);
public function verify($amount);

}
