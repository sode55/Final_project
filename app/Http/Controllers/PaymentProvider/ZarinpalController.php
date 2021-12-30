<?php

namespace App\Http\Controllers\PaymentProvider;

use Throwable;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Interfaces\PaymentInterface;
use App\Http\Controllers\Controller;
use App\Repositories\PaymentRepository;
use App\Repositories\BookingRepository;


class ZarinpalController extends Controller
{
//    use Responses;

    private $paymentService;
    public $user;

    public function __construct(
        PaymentInterface  $paymentService,
        BookingRepository $bookingRepository,
        PaymentRepository $paymentRepository
    )
    {
        $this->user = auth('api')->user();
        $this->paymentService = $paymentService;
        $this->bookingRepository = $bookingRepository;
        $this->paymentRepository = $paymentRepository;

    }

//    public function pay()

//    {
//        try {
//
//        $user = auth('api')->user();
//        $userId = $user->id;
//
//            $CallbackURL  = url('/http://127.0.0.1:8000/api/verify-with-zarinpal');
//            $MerchantID = "5e682ada-3b69-11e8-aaf3-005056a205be";
//            $Description = 'خرید بلیط اتوبوس';
//            $Amount = $this->bookingRepository->totalPrice($userId);
//            $Email = $user->email;
//            $Mobile = $user-> mobile;
//
//            $data = $this->paymentService->request($MerchantID, $Amount, $CallbackURL, $Description , $Email, $Mobile);
//
//        return response()->json([
//            "success" => true,
//            "message" => "جزییات پرداخت.",
//            'data' => $data,
//        ]);
//        } catch (Throwable $e) {
//            return response()->json([
//                'status' => $e->getCode(),
//                'error' => $e->getMessage(),
//            ]);
//        }
//    }
//
//    public function check()
//    {
//        try {
//
//            $user = auth('api')->user();
//            $userId = $user->id;
//
//            $Amount = $this->bookingRepository->totalPrice($userId);
//            $MerchantID = "5e682ada-3b69-11e8-aaf3-005056a205be";
//            $Authority =  $this->paymentRepository->transaction();
//
//            $data = $this->paymentService->verify($MerchantID, $Amount,$Authority);
//
//
//            return response()->json([
//                "success" => true,
//                "message" => "نتیجه تراکنش.",
//                'data' => $data,
//            ]);
//
//        } catch (Throwable $e) {
//            return response()->json([
//                'status' => $e->getCode(),
//                'error' => $e->getMessage(),
//            ]);
//        }
//    }
//
//    public function pay()
//
//    {
//        try {
//
//        $user = auth('api')->user();
//        $userId = $user->id;
//
//
//            $amount = $this->bookingRepository->totalPrice($userId);
//            $data = $this->paymentService->request($amount);
//
//
//        return response()->json([
//            "success" => true,
//            "message" => "جزییات پرداخت.",
//            'data' => $data
//        ]);
//        } catch (Throwable $e) {
//            return response()->json([
//                'status' => $e->getCode(),
//                'error' => $e->getMessage(),
//            ]);
//        }
//    }
//
//        public function check()
//    {
//        try {
//
//            $user = auth('api')->user();
//            $userId = $user->id;
//
//            $amount = $this->bookingRepository->totalPrice($userId);
//             $data = $this->paymentService->verify($amount);
//
//
//            return response()->json([
//                "success" => true,
//                "message" => "نتیجه تراکنش.",
//                'data' => $data,
//            ]);
//
//
//        } catch (Throwable $e) {
//            return response()->json([
//                'status' => $e->getCode(),
//                'error' => $e->getMessage(),
//            ]);
//        }
//    }


//public function pay()
//{
//    try {
//
//        $user = auth('api')->user();
//        $userId = $user->id;
//
//        $Amount = $this->bookingRepository->totalPrice($userId);
//
//         $TransactionId =  $this->paymentRepository->transaction();
//
//        $data = $this->paymentService->request($Amount, $TransactionId);
//
//
//        return response()->json([
//            "success" => true,
//            "message" => "جزییات پرداخت.",
//            'data' => $data,
//        ]);
//
//    } catch (Throwable $e) {
//        return response()->json([
//            'status' => $e->getCode(),
//            'error' => $e->getMessage(),
//        ]);
//    }
//}
//
//
//public function check()
//{
//    try {
//
//        $user = auth('api')->user();
//        $userId = $user->id;
//
//
//        $Amount = $this->bookingRepository->totalPrice($userId);
//        $Authority =  $this->paymentRepository->transaction();
//
//        $data = $this->paymentService->verify($Amount, $Authority);

//
//        return response()->json([
//            "success" => true,
//            "message" => "نتیجه تراکنش.",
//            'data' => $data,
//        ]);
//    } catch (Throwable $e) {
//        return response()->json([
//            'status' => $e->getCode(),
//            'error' => $e->getMessage(),
//        ]);
//    }
//}

    public function pay()
    {
        try {
            $Amount = $this->bookingRepository->totalPrice($this->user->id);
            $data = $this->paymentService->request($Amount, $this->user->email, $this->user->mobile);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "جزییات پرداخت.",
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function check(Request $request)
    {
        try {
            $Amount = $this->bookingRepository->totalPrice($this->user->id);
            $Authority = $this->paymentRepository->transaction();
            DB::beginTransaction();
            $data = $this->paymentService->verify($Amount, $Authority, $request);
            $ticket = $this->bookingRepository->ticket($this->user->id);
            SendEmailJob::dispatch($this->user->name, $this->userr->email, $ticket);
            DB::commit();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                "message" => "نتیجه تراکنش.",
                'data' => $data,
            ]);
        } catch (Throwable $e) {
            return response()->json(['status' => $e->getCode(),
                'error' => $e->getMessage(),]);
        }
    }
}
