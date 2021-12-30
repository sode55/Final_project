<?php

namespace App\Repositories;

use App\Models\Pay;

class PaymentRepository
{
    public function transaction()
    {
        $TransactionId = Pay::select('transaction_id')->latest()->first()->transaction_id;

        return $TransactionId;
    }
}
