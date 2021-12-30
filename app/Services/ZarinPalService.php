<?php

namespace App\Services;

use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use App\Interfaces\PaymentInterface;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use App\Models\Pay;


class ZarinPalService implements PaymentInterface
{

    public function request($amount)
    {
        $invoice = (new Invoice)->amount($amount);

        $request = Payment::purchase(
            $invoice,
            function($driver, $TransactionId) {
                global $input;
                $input['transaction_id'] = $TransactionId;
                $result = Pay::create($input);
            })->pay();
        $input['amount'] = $amount;
        $result = Pay::update($input);

        return $request;
    }

    public function verify($amount)
    {

        try {
            $receipt = Payment::amount($amount)->verify();

            $input = [];
            $input['refer_id'] = $receipt->getReferenceId();
            $result = Pay::update($input);

            return $receipt->getReferenceId();


        } catch (InvalidPaymentException $exception) {

            return $exception->getMessage();
        }
    }
}


