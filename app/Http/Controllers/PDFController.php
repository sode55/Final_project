<?php

namespace App\Http\Controllers;

use Throwable;
use App\Services\PDFService;
use Illuminate\Http\Request;
//use App\Http\Traits\Responses;
use App\Repositories\BookingRepository;


class PDFController extends Controller
{
//   use Responses;
    public function __construct(BookingRepository $bookingRepository,
                                PDFService $PDFService)
    {
        $this->bookingRepository = $bookingRepository;
        $this->PDFService = $PDFService;
    }

    public function index(Request $request)
    {
        if( $request->ajax() ){
            $data = $this->bookingRepository->ticket( auth('api')->user()->id);


//            return  $this->getMessage($response->json(), $response->status());
//        } catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());


            return  response()->json([
            "success" => true,
            "message" => "نمایش بلیط:",
            "data" => $data
            ]);
        }

        return view('pdf.index');
    }

    public function create()
    {
        try {
            $pdf =  $this->PDFService->generate();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());


     return response()->json()->download($pdf);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
