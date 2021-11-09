<?php

namespace APP\Http\Traits;

trait Responses
{
    public function gerErrors($error, $code)
    {
        return response()
            ->json([
                'error' => $error,
                'status' => $code
            ]);
    }

    public function getMessage($message, $code)
    {
        return response()
            ->json([
                'message' => $message,
                'status' => $code
            ]);
    }
}
