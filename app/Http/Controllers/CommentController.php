<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Throwable;

class CommentController extends Controller
{
//    use Responses;

public function __construct(CommentRepository $commentRepository)
{
    $this->commentRepository = $commentRepository;
}

//save company's comments
    public function store(CommentRequest $request)
    {
        try {
           $data = $this->commentRepository->save($request);

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "نظرات شما با موفقیت ثبت شد.",
                "data" => $data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
//show company's comments
    public function show()
    {
        try {

            $data = $this->commentRepository->list();

//            return  $this->getMessage($response->json(), $response->status());
//        }catch (Throwable $e) {
//            return $this->getError($response()->json(), $response()->status());

            return response()->json([
                "success" => true,
                'status' => 200,
                "message" => "نظرات شرکت های طرف قرارداد:",
                "data" =>$data
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => $e->getCode(),
                'error' => $e->getMessage(),
            ]);
        }
    }
}
